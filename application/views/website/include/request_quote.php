<section class="component-sm border-top" id="quoteform">
    <div class="container">
        <div class="row row-cols-1 g-4  row-cols-sm-2 mt-4">
            <div class="col">
                <div class="my-4" data-aos="fade-up">
                    <h1 class="h3 fw-bold">Let's push your business even higher.</h1>
                    <p class="card-text">Describe your needs so that our experts in the field can contact you within 24 hours to better listen to you.</p>
                    <img src="<?= assets('img/section/two-people-talking.jpg'); ?>?x" class="img-fluid" alt="" />
                </div>
            </div>
            <div class="col">
                <form action="/app/quote/request" id="requestquoteform" method="post" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control form-control-sm" id="name" name="name" maxlength="24" placeholder="What's your name" />
                        <label for="name">What's your name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control form-control-sm" id="business" required name="business" maxlength="24" placeholder="Business" />
                        <label for="business">What's the name of your Business</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control form-control-sm" id="address" required name="address" maxlength="128" placeholder="Location" />
                        <label for="address">Where are you locate</label>
                    </div>
                    <div class="text-muted font-notice mb-3 mt-1"><i class="bi bi-geo-alt-fill"></i> Country, City and address</div>
                    <div class="row row-cols-1 row-cols-sm-2 mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" inputmode="tel" maxlength="24" name="phone" required class="form-control form-control-sm" id="phone" placeholder="Your Phone number" />
                                <label for="phone">Your Phone number</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" inputmode="email" maxlength="45" name="email" required class="form-control form-control-sm" id="email" placeholder="Email address" />
                                <label for="email">Email address</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch"> <input type="checkbox" name="whatsapp" value="true" class="form-check-input" id="canusewhatsapp"> <label class="form-check-label" for="canusewhatsapp">This phone number use WhatsApp</label></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="label" for="interest">What are your needs today (Check to select)</label>
                        <div class="form-check form-switch"> <input type="checkbox" name="service[]" value="brand identity" class="form-check-input" id="check1"> <label class="form-check-label" for="check1">Create a logo and visual identity for my business</label></div>
                        <div class="form-check form-switch"> <input type="checkbox" name="service[]" value="Social media advertising" class="form-check-input" id="check2"> <label class="form-check-label" for="check2">Advertise on social networks</label></div>
                        <div class="form-check form-switch"> <input type="checkbox" name="service[]" value="marketing Strategy" class="form-check-input" id="check3"> <label class="form-check-label" for="check3">Design and deploy marketing strategy</label></div>
                        <div class="form-check form-switch"> <input type="checkbox" name="service[]" value="Website" class="form-check-input" id="check4"> <label class="form-check-label" for="check4">Create my website</label></div>
                        <div class="form-check form-switch"> <input type="checkbox" name="service[]" value="Mobile App" class="form-check-input" id="check5"> <label class="form-check-label" for="check5">Create my mobile application</label></div>
                        <div class="form-check form-switch"> <input type="checkbox" name="service[]" value="SEO" class="form-check-input" id="check6"> <label class="form-check-label" for="check6">Boost the visibility of my website (SEO)</label></div>
                        <div class="form-check form-switch"> <input type="checkbox" name="service[]" value="Influencer Marketing" class="form-check-input" id="check7"> <label class="form-check-label" for="check7">Communicate through influencers</label></div>
                        <div class="form-check form-switch"> <input type="checkbox" name="service[]" value="Email Marketing" class="form-check-input" id="check8"> <label class="form-check-label" for="check8">Deploy an email marketing campaign</label></div>
                        <div class="form-check form-switch"> <input type="checkbox" name="service[]" value="Software" class="form-check-input" id="check9"> <label class="form-check-label" for="check9">Automation and improvement of my management</label></div>
                        <div class="form-check form-switch"> <input type="checkbox" name="service[]" value="Partnership" class="form-check-input" id="check10"> <label class="form-check-label" for="check10">Partner with us</label></div>
                    </div>

                    <div class="form-floating">
                        <textarea class="form-control form-control-sm" placeholder="Leave a comment here" maxlength="300" id="comment" style="height: 100px"></textarea>
                        <label for="comment">Could you tell us a bit about the project?</label>
                    </div>
                    <div class="text-muted font-notice mb-3 mt-1">300 characters maximum is recommended</div>

                    <div class="form-floating mb-3">
                        <input type="number" inputmode="numeric" class="form-control form-control-sm" required value="0" min="50000" step="5000" name="budget" id="budget" placeholder="What about yout budget" />
                        <label for="budget">Do you have a budget in mind? (FCFA)</label>
                    </div>
                    <div class="mb-3">
                        <div class="g-recaptcha" data-sitekey="<?= $this->config->item("google-recaptcha-site-key"); ?>"></div>
                    </div>
                    <div class="mb-3">
                        <p class="font-notice">I have read and agree the <a target="_blank" class="a" title="Open in a new tab" href="/legal/terms">terms of use</a> and <a target="_blank" title="Open in a new tab" class="a" href="/legal/privacy-policy">privacy policy</a> regarding the use of users personal data by Openxtech.</p>
                    </div>
                    <div class="text-start"><button type="submit" class="btn btn-dark"><i class="bi bi-arrow-right-circle me-1"></i> Get a quote</button></div>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="<?= assets("js/validator.js"); ?>"></script>