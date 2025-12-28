<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" id="searchAccount" action="<?php echo e(route('search-account')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <input type="text" name="search" class="form-control" placeholder="Type keyword" required>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group ml-2">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover"  style="width: 100% !important;">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Account No.</th>
                            <th scope="col">Name</th>
                            <th scope="col">Father Name</th>
                            <th scope="col">Village</th>
                            <th scope="col">Mobile</th>
                        </tr>
                        </thead>
                        <tbody id="searchResult">
                        </tbody>
                    </table>
                </div>
            </div>
            </form>
        </div>
    </div>
</div><?php /**PATH /home/u574406823/domains/himachalsociety.com/public_html/casgahallian/resources/views/mylayout/search-account-popup.blade.php ENDPATH**/ ?>