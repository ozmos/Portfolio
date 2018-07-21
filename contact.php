<!--contact_container-->
<div class="contact_container bg_dark">
    <div id="contact_us" class="container center vertical-center">
        <div style="width: 100%">
            <div class="row top_45 btm_120">
                <div class="col-lg-6 col-lg-offset-3">
                    <h2>Contact Us</h2>
            
                    <div class="contact_large"><em>Call <span class="highlighted">{Insert telephone number here}</span><br> </em><span class="contact_medium" style="display: block; margin-top: -5px;">
                    <br>{Insert address here}</span></div>
                    <div class="top_60">
                        <em>Or</em><br>
                        <div class="contact_large work_orders">Send Us An Email</div>
                        <div class="highlighted"><em>Fill out an enquiry form below</em></div>
                    </div>

                    <!-- Form start -->
                    <form action="/contact-form/process.php" enctype="multipart/form-data" method="POST" name="contact" id="contact" class="ucf form-horizontal col-sm-8 col-sm-offset-2" novalidate>
                        <div class="message"></div>

                        <!--Name-->
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input class="form-control" type="text" name="name" id="name" size="30" placeholder="Name" required>
                            </div>
                        </div>

                        <!--Phone-->
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input class="form-control" type="tel" name="phone" id="phone" size="30" placeholder="Phone" required>
                            </div>
                        </div>

                        <!--Email-->
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input class="form-control" type="email" name="email" id="email" size="30" placeholder="Email" required>
                            </div>
                        </div>

                        <!--Subject-->
                        <!--                  <div class="form-group">
                                            <label for="subject" accesskey="S" class="col-sm-2 control-label">
                                              <span class="required">Subject</span>
                                            </label>
                                            <div class="col-sm-10">
                                              <select class="form-control" name="subject" id="subject" required>
                                                <option value="">Select one</option>
                                                <option value="support">Support</option>
                                                <option value="sales">Sales</option>
                                                <option value="bugs">Report a bug</option>
                                              </select>
                                            </div>
                                          </div>-->

                        <!--Comments-->
                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea class="form-control" name="message" id="message" cols="40" rows="3" placeholder="Comments"  required></textarea>
                            </div>
                        </div>

                        <!-- honeypot -->
                        <div class="form-group" style="left: -9999px; position: absolute;">
                            <label for="honey" class="col-sm-2 control-label">
                                Please leave this field empty - we're using it to stop robots submitting the form<br>
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="honey" id="honey">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="progress-container"></div>
                            <button type="submit" class="btn btn_submit btn-block">SUBMIT</button>
                        </div>

                    </form>
                    <!-- Form end -->

                </div>
            </div>
        </div>
    </div>
</div>
<!--contact_container-->