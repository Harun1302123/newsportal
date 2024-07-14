<section class="home-achevement-sec">
    <div class="container">
        <div class="nfis-sec-bdr-title">
            <h3 class="title-text">
                {{ languageStatus() == 'en' ? 'Financial Inclusion at a glance' : "এক নজরে আর্থিক অন্তর্ভুক্তি" }}
            </h3>
        </div>
        <div class="achevement-content">
            <div class="row">
                <div class="col fig-col">
                    <a href="{{ isset($financial_inclusion_bank->id) ? '/financial-inclusion-at-a-glance/?data=' . \App\Libraries\Encryption::encodeId($financial_inclusion_bank->id) : '#' }}" class="nfis-gif-item">
                        <div class="gif-icon flex-center">
                            <img src="{{ asset('images/financial-icon-01.svg') }}" alt="Bank Deposit Account">
                        </div>
                        <p>
                            {{ languageStatus() == 'en' ? 'Bank Deposit Account' : "ব্যাংক আমানত হিসাব" }}
                        </p>
                        <h3 class="achevement-num">
                            {{ languageStatus() == 'en' ?  $financial_inclusion_bank->total ?? 0 : \App\Libraries\CommonFunction::convert2Bangla( $financial_inclusion_bank->total ?? 0) }}
                        </h3>
                    </a>
                </div>
                <div class="col fig-col">
                    <a href="{{ isset($financial_inclusion_nbfi->id) ? '/financial-inclusion-at-a-glance/?data=' . \App\Libraries\Encryption::encodeId($financial_inclusion_nbfi->id) : '#' }}" class="nfis-gif-item">

                        <div class="gif-icon flex-center">
                            <img src="{{ asset('images/financial-icon-02.svg') }}" alt="Non Bank Financial Instituition Deposit Account">
                        </div>
                        <p>
                            {{ languageStatus() == 'en' ? 'Non Bank Financial Instituition Deposit Account' : "অ-ব্যাংক আর্থিক প্রতিষ্ঠান আমানত হিসাব" }}
                        </p>
                        <h3 class="achevement-num">
                            {{ languageStatus() == 'en' ?  $financial_inclusion_nbfi->total ?? 0 : \App\Libraries\CommonFunction::convert2Bangla($financial_inclusion_nbfi->total ?? 0) }}
                        </h3>
                    </a>
                </div>
                <div class="col fig-col">
                    <a href="{{ isset($financial_inclusion_mfs->id) ? '/financial-inclusion-at-a-glance/?data=' . \App\Libraries\Encryption::encodeId($financial_inclusion_mfs->id) : '#' }}" class="nfis-gif-item">
                        <div class="gif-icon flex-center">
                            <img src="{{ asset('images/financial-icon-03.svg') }}" alt="Mobile Financial Services Deposit Account">
                        </div>
                        <p>
                            {{ languageStatus() == 'en' ? 'Mobile Financial Services Deposit Account' : "মোবাইল আর্থিক সেবা হিসাব" }}
                        </p>
                        <h3 class="achevement-num">
                            {{ languageStatus() == 'en' ? $financial_inclusion_mfs->total ?? 0 : \App\Libraries\CommonFunction::convert2Bangla($financial_inclusion_mfs->total ?? 0) }}
                        </h3>
                    </a>
                </div>
                <div class="col fig-col">
                    <a href="{{ isset($financial_inclusion_mfis->id) ? '/financial-inclusion-at-a-glance/?data=' . \App\Libraries\Encryption::encodeId($financial_inclusion_mfis->id) : '#' }}" class="nfis-gif-item">
                        <div class="gif-icon flex-center">
                            <img src="{{ asset('images/financial-icon-04.svg') }}" alt="Micro Finance Institution Deposit Account">
                        </div>
                        <p>
                            {{ languageStatus() == 'en' ? 'Micro Finance Institution Deposit Account' : "ক্ষুদ্রঋণ প্রতিষ্ঠান আমানত হিসাব" }}
                        </p>
                        <h3 class="achevement-num">
                            {{ languageStatus() == 'en' ? $financial_inclusion_mfis->total ?? 0 : \App\Libraries\CommonFunction::convert2Bangla($financial_inclusion_mfis->total ?? 0) }}
                        </h3>
                    </a>
                </div>
                <div class="col fig-col">
                    <a href="{{ isset($financial_inclusion_cmis->id) ? '/financial-inclusion-at-a-glance/?data=' . \App\Libraries\Encryption::encodeId($financial_inclusion_cmis->id) : '#' }}" class="nfis-gif-item">
                        <div class="gif-icon flex-center">
                            <img src="{{ asset('images/financial-icon-05.svg') }}" alt="BO Account">
                        </div>
                        <p>
                            {{ languageStatus() == 'en' ? 'BO Account' : "বিও হিসাব" }}

                        </p>
                        <h3 class="achevement-num">
                            {{ languageStatus() == 'en' ? $financial_inclusion_cmis->total ?? 0 : \App\Libraries\CommonFunction::convert2Bangla($financial_inclusion_cmis->total ?? 0) }}
                        </h3>
                    </a>
                </div>
                <div class="col fig-col">
                    <a href="{{ isset($financial_inclusion_insurance->id) ? '/financial-inclusion-at-a-glance/?data=' . \App\Libraries\Encryption::encodeId($financial_inclusion_insurance->id) : '#' }}" class="nfis-gif-item">
                        <div class="gif-icon flex-center">
                            <img src="{{ asset('images/financial-icon-06.svg') }}" alt="Insurance Account">
                        </div>
                        <p>
                            {{ languageStatus() == 'en' ? 'Insurance Account' : "বীমা হিসাব" }}
                        </p>
                        <h3 class="achevement-num">
                            {{ languageStatus() == 'en' ? $financial_inclusion_insurance->total ?? 0 : \App\Libraries\CommonFunction::convert2Bangla($financial_inclusion_insurance->total ?? 0) }}
                        </h3>
                    </a>
                </div>
                <div class="col fig-col">
                    <a href="{{ isset($financial_inclusion_cooperatives->id) ? '/financial-inclusion-at-a-glance/?data=' . \App\Libraries\Encryption::encodeId($financial_inclusion_cooperatives->id) : '#' }}" class="nfis-gif-item">
                        <div class="gif-icon flex-center">
                            <img src="{{ asset('images/financial-icon-07.svg') }}" alt="Cooperative Account">
                        </div>
                        <p>
                            {{ languageStatus() == 'en' ? 'Cooperative Account' : "সমবায় হিসাব" }}
                        </p>
                        <h3 class="achevement-num">
                            {{ languageStatus() == 'en' ? $financial_inclusion_cooperatives->total ?? 0 : \App\Libraries\CommonFunction::convert2Bangla($financial_inclusion_cooperatives->total ?? 0) }}
                        </h3>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
