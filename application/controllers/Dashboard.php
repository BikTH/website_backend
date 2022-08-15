<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MaryFuneral
{



    function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        if (!$this->secure("admin", true)) {
            $this->pageview('sign/login', array("title" => "Login"));
        } else {
            $this->_app();
        }
    }


    public function _app()
    {
        $this->pageview('app/home', array("title" => "Hello"), "", true);
    }


    private function pageview($page = "", $data = null, $sub = "", $header = false)
    {
        $this->load->view("dashboard/header/head.php", array("seo_title" => $data['title'], "title" => $data['title'], "seo_description" => "", "seo_image" => ""));
        if ($header) {
            $this->load->view("dashboard/header/header.php", array("user" => $this->user, "data" => array()));
        }

        $this->load->view("dashboard/" . $sub . $page, array("master" => $this, "data" => $data));
        $this->load->view("dashboard/footer/footer.php");
    }


    public function connect()
    {
        $this->session->unset_userdata('user');

        $login = $this->input->post("username");
        $password = sha1($this->input->post("password"));

        $connect = $this->Base->getthis("admin", array("username" => $login, "password" => $password));
        if ($connect) {
            if ($this->managelogin($connect, "admin")) {
                redirect("/backoffice");
            } else {
                redirect("/backoffice");
            }
        } else {
            $this->alert->set("invalid", true);
            redirect("/backoffice");
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('user');
        redirect("https://www.maryfuneral.com/");
    }


    private function addmaster()
    {
        $data = array("role" => "admin", "name" => "Administrateur", "username" => "admin", "password" => sha1("0000"), "email" => "support@maryfuneral.com", "dateof" => now());
        $adminID = $this->Base->insertdata("admin", $data);
        if ($adminID) {
            echo "OK";
        }
    }


    public function open($module, $file)
    {
        sleep(1);
        $this->secure();
        $this->isAjax();
        $this->load->view("dashboard/app/" . $module . "/" . $file . ".php", array("master" => $this, "user" => $this->user));
    }


    public function updatepw()
    {
        $this->secure();
        $old = sha1($this->input->post("old"));
        $new = sha1($this->input->post("new"));
        //$name = $this->input->post("name");

        if ($this->user->password != $old or ($old == $new)) {
            $this->alert->set("invalid_password", true);
            redirect("/backoffice#/settings");
            return;
        }

        $updatePIN = $this->Base->updateData(array("password" => $new), array("id" => $this->user->id), "admin");

        $this->_updateUserdata(array("password" => $new));

        $this->alert->set("updated_password", true);
        redirect("/backoffice#/settings");
    }


    public function getcasket(){
        $data = $this->Base->get("casket");
        return $data ? $data : null;
    }


    public function quote($action = "")
    {
        $this->secure();
        if ($action == "get") {
            $data = $this->Base->getthis("quote", array("uid" => $this->input->get("id")));
            foreach ($data as $item) {
                unset($data->id);
            }
            echo json_encode($data);
        }
        if ($action == "read") {
            $data = $this->Base->updateData(array("quote_status" => "true"), array("uid" => $this->input->get("id")), "quote");
            $data = $this->Base->getthis("quote", array("uid" => $this->input->get("id")));
            echo json_encode(array("status" => true));
        }
    }

    public function call($func = null){
        return $this->$func();
    }








    function clearCasketImages($casketID)
    {
        $images = $this->Base->getwhere("images", array("casket" => $casketID), array("uid", "id", "name"));
        foreach ($images as $item) {
            $toClear[] = unlink_($this->dir_images . $item->name);
            $this->Base->deletedata("images", array("id" => $item->id));
        }
    }


    public function casket($action = "")
    {
        $this->secure();

        if ($action == "images") {
            $casket = $this->_get("casket", array("uid" => _get("id")));
            if (!$casket) {
                return null;
            }

            $images = $this->Base->getwhere("images", array("casket" => $casket->id), array("uid", "name"), 99, "dateof", "desc");

            return _echo($images);
        } elseif ($action == "clear") {
            $casket = $this->_get("casket", array("uid" => _post("id")));
            if (!$casket) {
                return null;
            }

            $this->clearCasketImages($casket->id);
            $this->Base->deletedata("casket", array("id" => $casket->id));

            return _echo(array("status" => true));
        } else {
            // vars
            $data = array(
                "name" => _post("name"),
                "type" => _post("type"),
                "description" => _textarea(_post("description")),
                "featured" => _post("featured") == "true" ? "true" : "false"
            );

            if ($action == "save") {
                if (_post("images") == "" or (gettype(_post("images")) == "array" && count(_post("images")) == 0)) {
                    return _echo(array("status" => false, "error" => "no-images"));
                }

                $data["uid"] = $this->get_uid();
                $data["dateof"] = now();
                $data["status"] = "false";

                $images = array();
                $storeID = $this->Base->insertdata("casket", $data);
                if ($storeID) {
                    foreach (_post("images") as $image) {
                        if (!empty($image)) {
                            $imageName = $this->saveImage($image, $this->get_uid(), $this->dir_images);
                            $images[] = $this->Base->insertdata("images", array("uid" => $this->get_uid(), "casket" => $storeID, "name" => $imageName, "status" => "true", "dateof" => now()));
                        }
                    }
                }

                $this->Base->updatedata(array("status" => "true"), array("id" => $storeID), "casket");

                return ($storeID && count($images) > 0 && count($images) == count(_post("images"))) ? _echo(array("status" => true)) : _echo(array("status" => false));
            } elseif ($action == "update") {

                $data["updateof"] = now();

                $casket = $this->_get("casket", array("uid" => _post("id")));
                if (!$casket) {
                    return;
                }

                if (_post("saves") != "" && gettype(_post("saves")) == "array") {

                    $toClear = array();
                    $images = $this->Base->getwhere("images", array("casket" => $casket->id), array("uid", "id", "name"));
                    foreach ($images as $item) {
                        if (!in_array($item->uid, _post("saves"))) {
                            // $toClear[] = $item->name;
                            $toClear[] = unlink_($this->dir_images . $item->name);
                            $this->Base->deletedata("images", array("id" => $item->id));
                        }
                    }
                } else {
                    if (_post("images") == "" or (gettype(_post("images")) == "array" && count(_post("images")) == 0)) {
                        return _echo(array("status" => false, "error" => "no-images"));
                    }
                }

                $this->Base->updatedata($data, array("id" => $casket->id), "casket");

                foreach (_post("images") as $image) {
                    if (!empty($image)) {
                        $imageName = $this->saveImage($image, $this->get_uid(), $this->dir_images);
                        $images[] = $this->Base->insertdata("images", array("uid" => $this->get_uid(), "casket" =>  $casket->id, "name" => $imageName, "status" => "true", "dateof" => now()));
                    }
                }

                return _echo(array("status" => true));
            }
        }
    }


    private function saveImage($data, $name, $DIR)
    {

        $this->load->helper("upload");

        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif
            $data = base64_decode($data);

            $file_contents = $data;

            $handle = new \Verot\Upload\Upload('data:' . $file_contents);

            if ($handle->uploaded) {
                $handle->image_resize = true;
                $handle->file_max_size = "20M";

                $handle->image_x = $handle->image_src_x > 1500 ? 1500 : $handle->image_src_x;
                $handle->image_ratio_y = true;

                $handle->file_new_name_body = "image-" . $name;
                $handle->image_convert = 'jpg';
                $handle->image_default_color = '#FFFFFF';

                $handle->process($DIR);
                if ($handle->processed) {
                    return $handle->file_dst_name;
                } else {
                    return false;
                }
            }
        }
    }


    public function getrequest()
    {
        $data = $this->Base->getwhere("quote", "", "*", 999, "dateof", "desc");
        return $data ? $data : null;
    }


    public function _getCasket()
    {
        $data = $this->Base->getwhere("casket", "", "*", 999, "featured", "desc");
        if ($data == null) {
            return null;
        } else {
            $result = array();
            foreach ($data as $item) {
                $x = $item;
                $x->images = $this->Base->getwhere("images", array("casket" => $item->id), "*", 99, "dateof", "desc");

                unset($x->id);

                $result[] = $x;
            }
            return $result;
        }
    }


    public function _getTestimonia()
    {
        $data = $this->Base->getwhere("testimonial", "", "*", 999, "dateof", "desc");
        if ($data == null) {
            return null;
        } else {
            foreach ($data as $item) {
                unset($item->id);
            }
            return $data;
        }
    }



    public function testimonial($action = "")
    {
        $this->secure();

        if ($action == "clear") {
            $testimonial = $this->_get("testimonial", array("uid" => _get("id")));
            if (!$testimonial) {
                return null;
            }

            $this->Base->deletedata("testimonial", array("id" => $testimonial->id));

            return _echo(array("status" => true));
        } else {
            // vars
            $data = array("name" => _textarea(_post("name"), 20), "gender" => _post("gender"), "comment" => _textarea(_post("message"), 300));

            if ($action == "save") {

                $data["uid"] = $this->get_uid();
                $data["dateof"] = now();
                $data["status"] = "true";

                $testimonialID = $this->Base->insertdata("testimonial", $data);

                return $testimonialID != null ? _echo(array("status" => true)) : _echo(array("status" => false));
            } elseif ($action == "update") {

                $data["updateof"] = now();

                $testimonial = $this->_get("testimonial", array("uid" => _post("id")));
                if (!$testimonial) {
                    return;
                }

                $this->Base->updatedata($data, array("id" => $testimonial->id), "testimonial");

                return _echo(array("status" => true));
            }
        }
    }
}
