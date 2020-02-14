<style>
    .modal-dialog {
        margin: 1.75em auto;
        min-height: calc(100vh - 60px);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    #myModal .close {
        position: absolute;
        right: 0.3rem;
    }

    .g-recaptcha div {
        margin: auto;
    }

    .modal-body .contact_form input[type='radio'] {
        width: auto;
        height: auto;
    }
    .modal-body .contact_form textarea{
        background-color: #eeeeee;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 10px;
        width: 100%;
        border: none
    }

    @media (max-width: 768px) {
        .modal-dialog {
            min-height: calc(100vh - 20px);
        }

        #myModal .modal-body {
            padding: 15px;
        }
    }

</style>
@if(!auth()->check())
    <div class="modal fade" id="howItWorkModal" tabindex="-1" role="dialog" aria-hidden="true" style="margin-top:2px!important;">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                 <div class="modal-header backgroud-style">

                    <div class="gradient-bg"></div>
                    <div class="popup-logo">
                        <img src="{{asset('assets/images/nic1.png')}}" alt="">
                    </div>
                    <div class="popup-text text-center">
                        @if(isset($logo))
                        <p><img src="{{asset('assets/images/'.$logo)}}"></p>
                        @else
                        <p><img src="{{asset('assets/images/nic.png')}}"></p>
                        @endif
                    </div>
                   

                </div>

                <!-- Modal body --> 
                <div class="modal-body">
                    <div class="tab-content">
                       video 
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else

@endif

@push('after-scripts')
    @if(config('access.captcha.registration'))
        {!! Captcha::script() !!}
    @endif

   
@endpush
