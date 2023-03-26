<!-- Modal of support -->
<div class="modal fade" id="supportModal" tabindex="-1" role="dialog" aria-labelledby="messengerModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background-color: #191919;padding: 50px; ">
            <div class="modal-header" style="border-bottom:none;">
                <h5 class="modal-title" style="color:#FFFFFF;"><?= __tr('Need some help?') ?></h5>
                <button type="button" style="color:#FFFFFF;margin-top: -40px; " class="close" data-dismiss="modal" aria-label="Close">
                    <span style="background-color: #222222;padding: 5px 10px;border-radius: 10px;" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:#FFFFFF;">
                <!-- Delete Account Form -->
                <form class="user lw-ajax-form lw-form" method="post" action="<?= route('user.write.request_support') ?>">
                    <div class="form-group" style="padding: 1px;object-fit: cover;background-color: transparent;background: transparent url(../../media-storage/modals/support_modal_main.png) no-repeat center center;border-radius: 15px;height: 170px;">
                    </div>
                    <!-- Delete Message -->
                    <h5><?= __tr('Describe your question and our specialists will answer you within 24 hours.') ?></h5>
                    <!-- /Delete Message -->

                    <div class="form-group partner pt mt-1">
                        <label>Request Subject</label>
                        <div class="position-relative">
                            <select size name="support_type"  style="background-color:#222222;border-radius: 1rem !important;color:#FFFFFF"  class="form-control form-control-user lw-user-gender-select-box" id="select_gender" required>
                                <option value="" selected disabled><?= __tr('Choose a type of your issue.') ?></option>
                                @foreach(configItem("support.support_types") as $key => $val)
                                    <option value="<?= $val ?>" > <?= $val ?> </option>
                                @endforeach		
                            </select>
                        </div>
                    </div>

                    <!-- description field -->
                    <div class="form-group">
                        <label for="desciption"><?= __tr('Description') ?></label>
                        <textarea class="form-control form-control-user lw-user-gender-select-box" style="background-color:#222222;border-radius: 1rem !important;color:#FFFFFF" name="description" id="description"></textarea>
                    </div>
                    <!-- description field -->

                    <!-- Delete Account -->
                    <button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user btn-block-on-mobile pull-right" style="border-radius: 1rem;"><?= __tr('Send Request')  ?></button>
                    <!-- / Delete Account -->
                </form>
                <!-- /Delete Account Form -->
            </div>
        </div>
    </div>
</div>
<!-- End Modal of support -->