<section class="">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="wrap-login">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="my-3 fw-bold">Mary Funeral Backoffice</h3>
                    </div>

                    <?php if ($this->alert->has_alert('invalid')) : ?>
                        <div class="alert alert-danger">Invalid credentials</div>
                    <?php elseif ($this->alert->has_alert('logout')) : ?>
                        <div class="alert alert-success">See you soon</div>
                    <?php elseif ($this->alert->has_alert('suspended')) : ?>
                        <div class="alert alert-danger">This account has been restricted</div>
                    <?php endif; ?>

                    <form autocomplete="off" id="" method="post" action="/backoffice/connect" class="m-t-20">
                        <div class="form-floating">
                            <input type="text" required autofocus inputmode="text" class="form-control" name="username" id="username" placeholder="Secure ID" />
                            <label for="username">Secure ID</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" required class="form-control" name="password" id="password" placeholder="Password" />
                            <label for="password">Password</label>
                        </div>

                        <div class="my-3 d-grid d-sm-block"><button type="submit" class="btn btn-dark">Get In <span class="bi bi-arrow-right-circle ms-1"></span></button></div>

                        <div class="text-muted font-notice m-t-20"><i class="bi bi-cone"></i> If you do not own this device, we recommend that you use the private browsing function of your browser.</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="area"><ul class="circles"><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li></ul></div>