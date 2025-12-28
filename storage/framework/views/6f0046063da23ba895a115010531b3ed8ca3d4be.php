<div class="modal fade" id="cashInHand" tabindex="-1" role="dialog" aria-labelledby="cashInHandLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">

                    <div class="col-12">
                        <form class="form-horizontal" id="searchDailyCash" action="<?php echo e(route('search.daily.cash.coin')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <fieldset>
                                <!-- Name input-->
                                <!-- Email input-->
                                <div class="form-group">
                                    <label class="col-md-3 col-lg-3 col-12 control-label" for="name1">Date</label>
                                    <div class="col-md-3">
                                        <input type="text" name="search" id="rangepicker4" class="form-control searchDailyCash" placeholder="Select Date" required>
                                    </div>
                                    <div class="col-md-3">
                                        Cash in Hand: <span id="searchDate"></span>
                                    </div>
                                    <div class="col-md-3">
                                        Sub Total: <span id="subTotal"></span>
                                    </div>
                                    <div class="col-md-3">
                                        Different: <span id="different"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-9 text-right btn-group-md">
                                        <button type="button" class="btn btn-info btn_sizes" id="calculateTotalDeiff"><i class="fa fa-save" aria-hidden="true"></i> Calculate</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <form class="form-horizontal" id="searchDailyCashUpdate" action="<?php echo e(route('search.daily.cash.coin.update')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="SelectedDate">
                    <fieldset>
                        <!-- Name input-->
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label" for="TwoThousand">2000 X </label>
                                <div class="col-md-6 col-lg-6 col-12">
                                    <input name="TwoThousand" type="number" class="form-control calculate" required value="0" onkeyup="calculateCoin(this,2000,'TwoThousand')">

                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <span id="TwoThousand"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label" for="FiveHundred">500 X </label>
                                <div class="col-md-6 col-lg-6 col-12">
                                    <input name="FiveHundred" type="number" class="form-control calculate" required value="0" onkeyup="calculateCoin(this,500,'FiveHundred')">

                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <span id="FiveHundred"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label" for="TwoHundred">200 X </label>
                                <div class="col-md-6 col-lg-6 col-12">
                                    <input name="TwoHundred" type="number" class="form-control calculate" required value="0" onkeyup="calculateCoin(this,200,'TwoHundred')">
                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <span id="TwoHundred"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label" for="OneHundred">100 X </label>
                                <div class="col-md-6 col-lg-6 col-12">
                                    <input name="OneHundred" type="number" class="form-control calculate" required value="0" onkeyup="calculateCoin(this,100,'OneHundred')">
                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <span id="OneHundred"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label" for="Fifty">50 X </label>
                                <div class="col-md-6 col-lg-6 col-12">
                                    <input name="Fifty" type="number" class="form-control calculate" required value="0" onkeyup="calculateCoin(this,50,'Fifty')">
                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <span id="Fifty"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label" for="Twenty">20 X </label>
                                <div class="col-md-6 col-lg-6 col-12">
                                    <input name="Twenty" type="number" class="form-control calculate" required value="0" onkeyup="calculateCoin(this,20,'Twenty')">
                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <span id="Twenty"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label" for="Ten">10 X </label>
                                <div class="col-md-6 col-lg-6 col-12">
                                    <input name="Ten" type="number" class="form-control calculate" required value="0" onkeyup="calculateCoin(this,10,'Ten')">
                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <span id="Ten"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label" for="Five">5 X </label>
                                <div class="col-md-6 col-lg-6 col-12">
                                    <input name="Five" type="number" class="form-control calculate" required value="0" onkeyup="calculateCoin(this,5,'Five')">
                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <span id="Five"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label" for="Two">2 X </label>
                                <div class="col-md-6 col-lg-6 col-12">
                                    <input name="Two" type="number" class="form-control calculate" required value="0" onkeyup="calculateCoin(this,2,'Two')">
                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <span id="Two"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label" for="One">1 X </label>
                                <div class="col-md-6 col-lg-6 col-12">
                                    <input name="One" type="number" class="form-control calculate" required value="0" onkeyup="calculateCoin(this,1,'One')">
                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <span id="One"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 col-lg-3 col-12 control-label" for="Paisa">Paisa</label>
                                <div class="col-md-6 col-lg-6 col-12">
                                    <input name="Paisa" type="number" class="form-control calculate" required value="0" onkeyup="calculateCoin(this,100,'Paisa')">
                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <span id="Paisa"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-9 text-right btn-group-md">
                                <button type="submit" class="btn btn-warning btn_sizes"><i class="fa fa-save" aria-hidden="true"></i> Update</button>
                            </div>
                            <div class="col-md-3 text-right btn-group-md">
                                <span id="coinTotal"></span>
                            </div>
                        </div>
                    </fieldset>

                </form>
            </div>
            </div>
        </div>
    </div>
<?php /**PATH /home/l0t4shykdrn8/public_html/casbatran.himachalsociety.com/resources/views/mylayout/cash-in-hand-popup.blade.php ENDPATH**/ ?>