<div class = "nfis-fi-block py-4" >
    @if(in_array($data->organization_type_id ?? 0, [1,2,3]))
        <div class = "nfis-fi-title" >
                                <span class = "fi-icon" >
                                    <img src = "{{ asset('images/financial-icon-01.svg') }}" alt = "Icon" >
                                </span >
            <span class = "fi-title" >
               {{ languageStatus() == 'en' ? $data->organization_types->financial_inclusion_title :  $data->organization_types->financial_inclusion_title_bn }} - {{ languageStatus() == 'en' ? $data->total : \App\Libraries\CommonFunction::convert2Bangla($data->total) }}
             </span>
        </div>        <div class="row fi-row-block">
            <div class="col">
                <div class="fi-box-item">
                    <div class="fi-item-icon">
                        <img src="{{ asset('images/financial-inclusion/fi-icon-male.svg') }}" alt="Icon">
                    </div>
                    <span class="fi-item-name">{{ languageStatus() == 'en' ? 'Male' : "পুরুষ" }}</span>
                    <h3 class="fi-item-number">
                        {{ languageStatus() == 'en' ? $male ?? 0 : \App\Libraries\CommonFunction::convert2Bangla($male ?? 0) }}
                    </h3>
                </div>
            </div>
            <div class="col">
                <div class="fi-box-item">
                    <div class="fi-item-icon">
                        <img src="{{ asset('images/financial-inclusion/fi-icon-female.svg') }}" alt="Icon">
                    </div>
                    <span class="fi-item-name">{{ languageStatus() == 'en' ? 'Female' : "নারী" }}</span>
                    <h3 class="fi-item-number">
                        {{ languageStatus() == 'en' ? $female ?? 0 : \App\Libraries\CommonFunction::convert2Bangla($female ?? 0) }}
                    </h3>
                </div>
            </div>
            <div class="col">
                <div class="fi-box-item">
                    <div class="fi-item-icon">
                        <img src="{{ asset('images/financial-inclusion/fi-icon-others.svg') }}" alt="Icon">
                    </div>
                    <span class="fi-item-name">{{ languageStatus() == 'en' ? 'Others' : "অন্যান্য" }}</span>
                    <h3 class="fi-item-number">
                        {{ languageStatus() == 'en' ? $others ?? 0 : \App\Libraries\CommonFunction::convert2Bangla($others ?? 0) }}

                    </h3>
                </div>
            </div>
            <div class="col">
                <div class="fi-box-item">
                    <div class="fi-item-icon">
                        <img src="{{ asset('images/financial-inclusion/fi-icon-rural.svg') }}" alt="Icon">
                    </div>
                    <span class="fi-item-name">{{ languageStatus() == 'en' ? 'Rural' : "গ্রাম" }}</span>
                    <h3 class="fi-item-number">
                        {{ languageStatus() == 'en' ? $rural ?? 0 : \App\Libraries\CommonFunction::convert2Bangla($rural ?? 0) }}

                    </h3>
                </div>
            </div>
            <div class="col">
                <div class="fi-box-item">
                    <div class="fi-item-icon">
                        <img src="{{ asset('images/financial-inclusion/fi-icon-urban.svg') }}" alt="Icon">
                    </div>
                    <span class="fi-item-name">{{ languageStatus() == 'en' ? 'Urban' : "শহর" }}</span>
                    <h3 class="fi-item-number">
                        {{ languageStatus() == 'en' ? $urban ?? 0 : \App\Libraries\CommonFunction::convert2Bangla($urban ?? 0) }}

                    </h3>

                </div>
            </div>
        </div>
    @elseif(in_array($data->organization_type_id ?? 0, [4,5,6,7]))
        <div class = "nfis-fi-title" >
                                <span class = "fi-icon" >
                                    <img src = "{{ asset('images/financial-icon-01.svg') }}" alt = "Icon" >
                                </span >
            <span class = "fi-title" >
                            {{ languageStatus() == 'en' ? $data->organization_types->financial_inclusion_title :  $data->organization_types->financial_inclusion_title_bn }} - {{ languageStatus() == 'en' ? $data->total : \App\Libraries\CommonFunction::convert2Bangla($data->total) }}
                             </span>
        </div>
        <div class="row fi-row-block details-body-2" style="justify-content: center">
            <div class="fi-box-item">
                <div class="fi-item-icon">
                    <img src="{{ asset('images/financial-inclusion/fi-icon-male.svg') }}" alt="Icon">
                </div>
                <span class="fi-item-name">{{ languageStatus() == 'en' ? 'Male' : "পুরুষ" }}</span>
                <h3 class="fi-item-number">
                    {{ languageStatus() == 'en' ? $male ?? 0 : \App\Libraries\CommonFunction::convert2Bangla($male ?? 0) }}

                </h3>
            </div>
            <div class="fi-box-item">
                <div class="fi-item-icon">
                    <img src="{{ asset('images/financial-inclusion/fi-icon-female.svg') }}" alt="Icon">
                </div>
                <span class="fi-item-name">{{ languageStatus() == 'en' ? 'Female' : "নারী" }}</span>
                <h3 class="fi-item-number">
                    {{ languageStatus() == 'en' ? $female ?? 0 : \App\Libraries\CommonFunction::convert2Bangla($female ?? 0) }}
                </h3>
            </div>
        </div>
    @else
        <h4>No Data Found !!!!!!!!!</h4>

    @endif
</div>
