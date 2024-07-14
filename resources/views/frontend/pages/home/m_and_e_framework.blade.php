<section class="nfis-financial-sec"
    style="background: url('{{ asset('images/financial_inclusion_access.webp') }}')no-repeat center center/cover">
    <div class="container">
        <div class="financial-sec-container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <span style="cursor: pointer;" data-toggle="modal" data-target="#exampleModal">
                        <div class="nfis-green-box">
                            <span class="fnc-subtitle">NFIS Implementation Progress</span>
                            <h3 id="publish_score_data"></h3>
                        </div>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h3 id="publish_status"></h3>
                <h3 id="publish_score"></h3>
            </div>
        </div>
    </div>
</div>
