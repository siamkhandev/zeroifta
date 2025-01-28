@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
                            <!-- Section 1 -->
                            <div class="manage-comp mb-4">
                                <div class="Filters-main mb-3 mb-md-4">
                                    <div class="sec1-style">
                                        <div class="subs_plan">
                                            <div class="inHead-span">
                                                <h2 class="head-20Med">{{__('messages.Subscription Plans')}}</h2>
                                                <div class="plans-toggel">
                                                <div class="sub-toggel text-center">
                                                    <div>
                                                    <p>Monthly</p>
                                                    </div>
                                                    <div>
                                                    <label class="switch">
                                                        <input type="checkbox" id="plansSwitchCheckbox">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    </div>
                                                    <div>
                                                    <div>
                                                        <p>Yearly</p>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <div id="monthly_plans" class="monthly_plans">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-12 mb-4">
                                                        <div class="price_plans sbsp-com weekly-plan">
                                                        <div class="ph-area">
                                                            <h3>Free Trial</h3>
                                                            <p style="color:#B60F0F;"> Trial Plan (6 Month Only)</p>
                                                        </div>
                                                        <div class="sbp-section">
                                                            <div>
                                                            <p class="">
                                                                <span class="usp-head">You are availing all the features of the</span>
                                                                <span class="usp-ys"> <b>Premium Monthly Plan</b> </span>
                                                                <span class="usp-head">for 6 months.</span>

                                                            </p>
                                                            </div>
                                                            <div class="pt-4">
                                                            <ul>
                                                                <li class="sbp-list mb-3">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 28 28" fill="none">
                                                                    <g clip-path="url(#clip0_2807_1039)">
                                                                        <path d="M26.1395 2.69597C25.6332 2.49558 25.0584 2.62742 24.6893 3.02292L19.5107 9.64109L15.1338 1.14558C14.8965 0.7448 14.4693 0.496948 14 0.496948C13.5307 0.496948 13.0982 0.7448 12.8662 1.14558L8.48926 9.64109L3.31074 3.0282C2.9416 2.63269 2.3668 2.50085 1.86055 2.70125C1.35957 2.89636 1.02734 3.38152 1.02734 3.92468V21.4852C1.02734 23.3731 2.56719 24.913 4.45508 24.913H23.5449C25.4328 24.913 26.9727 23.3731 26.9727 21.4852V3.92468C26.9727 3.38152 26.6404 2.89636 26.1395 2.69597Z" fill="#FFBC13" />
                                                                    </g>
                                                                    <defs>
                                                                        <clipPath id="clip0_2807_1039">
                                                                        <rect width="27" height="27" fill="white" transform="translate(0.5 0.0487061)" />
                                                                        </clipPath>
                                                                    </defs>
                                                                    </svg>
                                                                </span>
                                                                <div>
                                                                    <p class="">
                                                                    <span class="usp-yellow">
                                                                        After the trial period, the subscription will automatically roll into the
                                                                    </span>
                                                                    <br>
                                                                    <span class="usp-ys blink_me">
                                                                        premium plan at $67 per month
                                                                    </span>

                                                                    </p>
                                                                </div>
                                                                </li>
                                                            </ul>
                                                            </div>
                                                            <div class="text-center mb-5 mt-3">
                                                            <p class="usp-para">
                                                                Invest in the Premium + Yearly Subscription today and experience the complete power of ZeroIFTA!
                                                            </p>
                                                            </div>

                                                        </div>

                                                        </div>
                                                    </div>
                                                    <!-- Plan 2 -->
                                                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-12 mb-4">
                                                        <div class="price_plans sbsp-com weekly-plan">
                                                        <div class="ph-area">
                                                            <h3>Basic Plan</h3>
                                                            <p> $55 - Monthly</p>
                                                        </div>
                                                        <div class="sbp-section">
                                                            <div>
                                                            <h4 class="pb-3">Features</h4>
                                                            <div class="pp-inn">
                                                                <ul>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">Fuel Station Recommendations</p>
                                                                    <p class="usp-para">Get the best fuel stops based on the unburdened fuel price to maximize savings.</p>
                                                                    </div>
                                                                </li>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">Monthly Savings and IFTA Reports</p>
                                                                    <p class="usp-para">Review your savings each month to track how much you've kept in your pocket.</p>
                                                                    </div>
                                                                </li>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">Customize odometer reading and truck MPG's</p>
                                                                    </div>
                                                                </li>
                                                                </ul>
                                                            </div>
                                                            </div>
                                                            <div class="pt-5">
                                                            <h4 class="pb-3">What's Not Included:</h4>
                                                            <div class="pp-inn">
                                                                <ul>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                                                                        <path d="M10.0934 10.0146L5.92676 5.8479M10.0934 10.0146L14.2601 14.1812M10.0934 10.0146L14.2601 5.8479M10.0934 10.0146L5.92676 14.1812" stroke="#B60F0F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">No live vehicle tracking or alerts.</p>
                                                                    <p class="usp-para">Get the best fuel stops based on the unburdened fuel price to maximize savings.</p>
                                                                    </div>
                                                                </li>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                                                                        <path d="M10.0934 10.0146L5.92676 5.8479M10.0934 10.0146L14.2601 14.1812M10.0934 10.0146L14.2601 5.8479M10.0934 10.0146L5.92676 14.1812" stroke="#B60F0F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-para">No customization of app features, such as setting a minimum number of gallons to fuel, adding stops to trips, or change the default reserve fuel amount.</p>
                                                                    </div>
                                                                </li>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                                                                        <path d="M10.0934 10.0146L5.92676 5.8479M10.0934 10.0146L14.2601 14.1812M10.0934 10.0146L14.2601 5.8479M10.0934 10.0146L5.92676 14.1812" stroke="#B60F0F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-para">Can't customize fuel tank capacity </p>
                                                                    </div>
                                                                </li>
                                                                </ul>
                                                            </div>
                                                            </div>
                                                            <!-- Button -->
                                                            <div class="palns-btn mt-5">
                                                            @if($userPlan->planName->slug=="basic_monthly")
                                                            <a href="{{route('cancel.subscription',$userPlan->stripe_subscription_id)}}" class="mainBtn">
                                                                Cancel Subscription
                                                            </a>
                                                            @else
                                                            <a href="{{route('buy','basic_monthly')}}" class="mainBtn">
                                                                Upgrade
                                                            </a>
                                                            @endif
                                                            </div>
                                                        </div>

                                                        </div>
                                                    </div>
                                                    <!-- Plan 3 -->
                                                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-12 mb-4">
                                                        <div class="price_pm sbsp-com montly-plan top-plan">
                                                        <div class="pop-div">
                                                            <span>Recommended</span>
                                                        </div>
                                                        <div class="ph-area">
                                                            <h3 style="color:#ffbc13;">Premium Plan</h3>
                                                            <p> $67 - Monthly</p>
                                                        </div>
                                                        <div class="sbp-section">
                                                            <!-- Sec 1 -->
                                                            <div>
                                                            <h4 class="pb-3">Features</h4>
                                                            <div class="pp-inn">
                                                                <ul>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">All Features of the Basic Plan.</p>
                                                                    </div>
                                                                </li>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">Automatic IFTA Reporting: </p>
                                                                    <p class="usp-para">Simplify compliance with automated tax reporting.</p>
                                                                    </div>
                                                                </li>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">Fully Customizable App and Features:</p>
                                                                    <p class="usp-para">
                                                                        <b>Tailor the app to your needs.</b>
                                                                    </p>
                                                                    <ul class="pt-2">
                                                                        <li class="sbp-list mb-3">
                                                                        <span style="color: #19A130">
                                                                            <!-- <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#19A130">
                                                                            <path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z" />
                                                                        </svg> -->
                                                                            <p>
                                                                            <b>1.</b>
                                                                            </p>
                                                                        </span>
                                                                        <div>
                                                                            <p class="usp-para">
                                                                            Adjust settings like minimum gallons to fuel,
                                                                            </p>
                                                                        </div>
                                                                        </li>
                                                                        <li class="sbp-list mb-3">
                                                                        <span style="color: #19A130">
                                                                            <p>
                                                                            <b>2.</b>
                                                                            </p>
                                                                        </span>
                                                                        <div>
                                                                            <p class="usp-para">
                                                                            Add unlimited stops to trips,
                                                                            </p>
                                                                        </div>
                                                                        </li>
                                                                        <li class="sbp-list mb-3">
                                                                        <span style="color: #19A130">
                                                                            <p>
                                                                            <b>3.</b>
                                                                            </p>
                                                                        </span>
                                                                        <div>
                                                                            <p class="usp-para">
                                                                            Change the default reserve fuel amount,
                                                                            </p>
                                                                        </div>
                                                                        </li>
                                                                        <li class="sbp-list mb-3">
                                                                        <span style="color: #19A130">
                                                                            <p>
                                                                            <b>4.</b>
                                                                            </p>
                                                                        </span>
                                                                        <div>
                                                                            <p class="usp-para">
                                                                            Customize odometer reading and truck MPG's,
                                                                            </p>
                                                                        </div>
                                                                        </li>
                                                                        <li class="sbp-list mb-3">
                                                                        <span style="color: #19A130">
                                                                            <p>
                                                                            <b>5.</b>
                                                                            </p>
                                                                        </span>
                                                                        <div>
                                                                            <p class="usp-para">
                                                                            Customizable alerts (choose at wish preferred distances to get notified of your upcoming stop)
                                                                            </p>
                                                                        </div>
                                                                        </li>
                                                                    </ul>

                                                                    </div>
                                                                </li>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">Live Vehicle Tracking: </p>
                                                                    <p class="usp-para">Monitor your fleet in real-time and track your trucks' positions.</p>
                                                                    </div>
                                                                </li>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">Alerts and Notifications: </p>
                                                                    <p class="usp-para">Receive alerts if drivers miss suggested fuel stops or deviate from planned routes.</p>
                                                                    </div>
                                                                </li>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">Advanced Trip Planning and Analytics: </p>
                                                                    <p class="usp-para">Optimize routes with predictive fuel pricing, weather, traffic behavior and vehicle performance data.</p>
                                                                    </div>
                                                                </li>
                                                                </ul>
                                                            </div>
                                                            </div>


                                                            <!-- Button -->
                                                            <div class="palns-btn mt-5">
                                                            <a href="{{route('buy','premium_monthly')}}" class="mainBtn">
                                                                Buy Plan
                                                            </a>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <!-- Plan 4 -->
                                                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-12 mb-4">
                                                        <div class="price_plans sbsp-com weekly-plan">
                                                        <div class="ph-area">
                                                            <h3>Premium+ Subscription </h3>
                                                            <p> $97 - Monthly</p>
                                                        </div>
                                                        <div class="sbp-section">
                                                            <div>
                                                            <p class="usp-para pb-2">
                                                                Our Premium+ Subscription offers the most comprehensive set of features designed to elevate your
                                                                fleet management experience. This plan includes everything from our Basic and Premium plans,
                                                                plus advanced integrations to maximize efficiency and streamline operations.
                                                            </p>
                                                            <h4 class="pb-3">What's Included</h4>
                                                            <div class="pp-inn">
                                                                <ul>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">Fuel Station Recommendations</p>
                                                                    <p class="usp-para">Based on unburdened fuel prices for smarter fueling decisions.</p>
                                                                    </div>
                                                                </li>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">Monthly Savings Reports</p>
                                                                    <p class="usp-para"> Track your savings and optimize your costs.</p>
                                                                    </div>
                                                                </li>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">Automatic IFTA Reporting</p>
                                                                    <p class="usp-para">Eliminate audits and simplify tax compliance with automated reporting.</p>
                                                                    </div>
                                                                </li>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">Live Vehicle Tracking and Alerts</p>
                                                                    <p class="usp-para">Real-time tracking of all trucks, with alerts for missed fuel stops and deviations from optimized routes.</p>
                                                                    </div>
                                                                </li>

                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">Fully Customizable App</p>
                                                                    <p class="usp-para">Set your minimum fueling amounts, add stops, and personalize features to fit your unique needs.</p>
                                                                    </div>
                                                                </li>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">Admin Panel API Integration</p>
                                                                    <p class="usp-para">
                                                                        Sync your existing fleet software with ZeroIFTA. All truck, driver,
                                                                        and essential fleet information is automatically shared and
                                                                        updated without manual input, ensuring a streamlined workflow between systems.
                                                                    </p>
                                                                    </div>
                                                                </li>
                                                                <li class="sbp-list mb-3">
                                                                    <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                        <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                    </svg>
                                                                    </span>
                                                                    <div>
                                                                    <p class="usp-head">Real-Time Data Sync</p>
                                                                    <p class="usp-para">
                                                                        Maintain accurate fleet information with automatic updates, helping you keep track of crucial data effortlessly.
                                                                    </p>
                                                                    </div>
                                                                </li>
                                                                </ul>
                                                            </div>
                                                            </div>
                                                            <!-- Button -->
                                                            <div class="palns-btn mt-5">
                                                            <a href="{{route('buy','premium_plus_monthly')}}" class="mainBtn">
                                                                Buy Plan
                                                            </a>
                                                            </div>
                                                        </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div id="yearly_plans" class="yearly_plans" style="display: none;">
                                                <div class="text-center mb-5 mt-3">
                                                <p>
                                                    Invest in the Premium + Yearly Subscription today and experience the complete power of ZeroIFTA!
                                                </p>
                                                </div>
                                                <div class="row">
                                                <!-- Plan 1 -->
                                                <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-12 mb-4">
                                                    <div class="price_plans sbsp-com weekly-plan">
                                                    <div class="ph-area">
                                                        <h3>Free Trial</h3>
                                                        <p style="color:#B60F0F;"> Trial Plan (6 Month Only)</p>
                                                    </div>
                                                    <div class="sbp-section">
                                                        <div>
                                                        <p class="">
                                                            <span class="usp-head">You are availing all the features of the</span>
                                                            <span class="usp-ys"> <b>Premium Monthly Plan</b> </span>
                                                            <span class="usp-head">for 6 months.</span>

                                                        </p>
                                                        </div>
                                                        <div class="pt-4">
                                                        <ul>
                                                            <li class="sbp-list mb-3">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 28 28" fill="none">
                                                                <g clip-path="url(#clip0_2807_1039)">
                                                                    <path d="M26.1395 2.69597C25.6332 2.49558 25.0584 2.62742 24.6893 3.02292L19.5107 9.64109L15.1338 1.14558C14.8965 0.7448 14.4693 0.496948 14 0.496948C13.5307 0.496948 13.0982 0.7448 12.8662 1.14558L8.48926 9.64109L3.31074 3.0282C2.9416 2.63269 2.3668 2.50085 1.86055 2.70125C1.35957 2.89636 1.02734 3.38152 1.02734 3.92468V21.4852C1.02734 23.3731 2.56719 24.913 4.45508 24.913H23.5449C25.4328 24.913 26.9727 23.3731 26.9727 21.4852V3.92468C26.9727 3.38152 26.6404 2.89636 26.1395 2.69597Z" fill="#FFBC13" />
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_2807_1039">
                                                                    <rect width="27" height="27" fill="white" transform="translate(0.5 0.0487061)" />
                                                                    </clipPath>
                                                                </defs>
                                                                </svg>
                                                            </span>
                                                            <div>
                                                                <p class="">
                                                                <span class="usp-yellow">
                                                                    After the trial period, the subscription will automatically roll into the
                                                                </span>
                                                                <br>
                                                                <span class="usp-ys blink_me">
                                                                    premium plan at $67 per month
                                                                </span>

                                                                </p>
                                                            </div>
                                                            </li>
                                                        </ul>
                                                        </div>
                                                        <div class="text-center mb-5 mt-3">
                                                        <p class="usp-para">
                                                            Invest in the Premium + Yearly Subscription today and experience the complete power of ZeroIFTA!
                                                        </p>
                                                        </div>

                                                    </div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-12 col-12 mb-4">
                                                    <div class="price_plans sbsp-com weekly-plan">
                                                    <div class="ph-area">
                                                        <h3>Basic Plan</h3>
                                                        <p> $595 - Year</p>
                                                        <span class="pt-1 usp-para">Equivalent to $49.58 per month (9.85% discount)</span>
                                                    </div>
                                                    <div class="sbp-section">
                                                        <div>
                                                        <h4 class="pb-3">Features</h4>
                                                        <div class="pp-inn">
                                                            <ul>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">Fuel Station Recommendations</p>
                                                                <p class="usp-para">Get the best fuel stops based on the unburdened fuel price to maximize savings.</p>
                                                                </div>
                                                            </li>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">Monthly Savings and IFTA Reports</p>
                                                                <p class="usp-para">Review your savings each month to track how much you've kept in your pocket.</p>
                                                                </div>
                                                            </li>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">Customize odometer reading and truck MPG's</p>
                                                                </div>
                                                            </li>
                                                            </ul>
                                                        </div>
                                                        </div>
                                                        <div class="pt-5">
                                                        <h4 class="pb-3">What's Not Included:</h4>
                                                        <div class="pp-inn">
                                                            <ul>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                                                                    <path d="M10.0934 10.0146L5.92676 5.8479M10.0934 10.0146L14.2601 14.1812M10.0934 10.0146L14.2601 5.8479M10.0934 10.0146L5.92676 14.1812" stroke="#B60F0F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">No live vehicle tracking or alerts.</p>
                                                                </div>
                                                            </li>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                                                                    <path d="M10.0934 10.0146L5.92676 5.8479M10.0934 10.0146L14.2601 14.1812M10.0934 10.0146L14.2601 5.8479M10.0934 10.0146L5.92676 14.1812" stroke="#B60F0F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-para">No customization of app features, such as setting a minimum number of gallons to fuel, adding stops to trips, or change the default reserve fuel amount.</p>
                                                                </div>
                                                            </li>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                                                                    <path d="M10.0934 10.0146L5.92676 5.8479M10.0934 10.0146L14.2601 14.1812M10.0934 10.0146L14.2601 5.8479M10.0934 10.0146L5.92676 14.1812" stroke="#B60F0F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-para">Can't customize fuel tank capacity </p>
                                                                </div>
                                                            </li>
                                                            </ul>
                                                        </div>
                                                        </div>
                                                        <!-- Button -->
                                                        <div class="palns-btn mt-5">
                                                        <a href="{{route('buy','basic_yearly')}}" class="mainBtn">
                                                            Buy Plan
                                                        </a>
                                                        </div>
                                                    </div>

                                                    </div>
                                                </div>
                                                <!-- Plan 2 -->
                                                <div class="col-lg-3 col-md-6 col-sm-12 col-12 mb-4">
                                                    <div class="price_pm sbsp-com montly-plan top-plan">
                                                    <div class="pop-div">
                                                        <span>Recommended</span>
                                                    </div>
                                                    <div class="ph-area">
                                                        <h3>Premium Plan</h3>
                                                        <p> $730 - Year</p>
                                                        <span class="pt-1 usp-para">Equivalent to $60.83 per month (9.21% discount)</span>
                                                    </div>
                                                    <div class="sbp-section">
                                                        <!-- Sec 1 -->
                                                        <div>
                                                        <h4 class="pb-3">Features</h4>
                                                        <div class="pp-inn">
                                                            <ul>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">All Features of the Basic Plan.</p>
                                                                </div>
                                                            </li>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">Automatic IFTA Reporting: </p>
                                                                <p class="usp-para">Simplify compliance with automated tax reporting.</p>
                                                                </div>
                                                            </li>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">Fully Customizable App and Features:</p>
                                                                <p class="usp-para">
                                                                    <b>Tailor the app to your needs.</b>
                                                                </p>
                                                                <ul class="pt-2">
                                                                    <li class="sbp-list mb-3">
                                                                    <span style="color: #19A130">
                                                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#19A130">
                                                                        <path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z" />
                                                                    </svg> -->
                                                                        <p>
                                                                        <b>1.</b>
                                                                        </p>
                                                                    </span>
                                                                    <div>
                                                                        <p class="usp-para">
                                                                        Adjust settings like minimum gallons to fuel,
                                                                        </p>
                                                                    </div>
                                                                    </li>
                                                                    <li class="sbp-list mb-3">
                                                                    <span style="color: #19A130">
                                                                        <p>
                                                                        <b>2.</b>
                                                                        </p>
                                                                    </span>
                                                                    <div>
                                                                        <p class="usp-para">
                                                                        Add unlimited stops to trips,
                                                                        </p>
                                                                    </div>
                                                                    </li>
                                                                    <li class="sbp-list mb-3">
                                                                    <span style="color: #19A130">
                                                                        <p>
                                                                        <b>3.</b>
                                                                        </p>
                                                                    </span>
                                                                    <div>
                                                                        <p class="usp-para">
                                                                        Change the default reserve fuel amount,
                                                                        </p>
                                                                    </div>
                                                                    </li>
                                                                    <li class="sbp-list mb-3">
                                                                    <span style="color: #19A130">
                                                                        <p>
                                                                        <b>4.</b>
                                                                        </p>
                                                                    </span>
                                                                    <div>
                                                                        <p class="usp-para">
                                                                        Customize odometer reading and truck MPG's,
                                                                        </p>
                                                                    </div>
                                                                    </li>
                                                                    <li class="sbp-list mb-3">
                                                                    <span style="color: #19A130">
                                                                        <p>
                                                                        <b>5.</b>
                                                                        </p>
                                                                    </span>
                                                                    <div>
                                                                        <p class="usp-para">
                                                                        Customizable alerts (choose at wish preferred distances to get notified of your upcoming stop)
                                                                        </p>
                                                                    </div>
                                                                    </li>
                                                                </ul>

                                                                </div>
                                                            </li>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">Live Vehicle Tracking: </p>
                                                                <p class="usp-para">Monitor your fleet in real-time and track your trucks' positions.</p>
                                                                </div>
                                                            </li>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">Alerts and Notifications: </p>
                                                                <p class="usp-para">Receive alerts if drivers miss suggested fuel stops or deviate from planned routes.</p>
                                                                </div>
                                                            </li>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">Advanced Trip Planning and Analytics: </p>
                                                                <p class="usp-para">Optimize routes with predictive fuel pricing, weather, traffic behavior and vehicle performance data.</p>
                                                                </div>
                                                            </li>
                                                            </ul>
                                                        </div>
                                                        </div>


                                                        <!-- Button -->
                                                        <div class="palns-btn mt-5">
                                                        <a href="{{route('buy','premium_yearly')}}" class="mainBtn">
                                                            Buy Plan
                                                        </a>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                <!-- Plan 3 -->
                                                <div class="col-lg-3 col-md-6 col-sm-12 col-12 mb-4">
                                                    <div class="price_plans sbsp-com weekly-plan">
                                                    <div class="ph-area">
                                                        <h3>Premium+ Subscription </h3>
                                                        <p> $995 - Year</p>
                                                        <span class="pt-1 usp-para">Equivalent to $82.91 per month (14.53% discount)</span>
                                                    </div>
                                                    <div class="sbp-section">
                                                        <div>
                                                        <p class="usp-para pb-2">
                                                            The Premium+ Yearly Subscription gives you full access to all of ZeroIFTA's most
                                                            powerful features at a discounted rate, offering the ultimate solution for
                                                            fleet management and fuel optimization.
                                                        </p>
                                                        <h4 class="pb-3">What's Included</h4>
                                                        <div class="pp-inn">
                                                            <ul>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">Fuel Station Recommendations:</p>
                                                                <p class="usp-para">Based on unburdened fuel prices for smarter fueling decisions.</p>
                                                                </div>
                                                            </li>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">Monthly Savings Reports:</p>
                                                                <p class="usp-para"> Track your savings and optimize your costs.</p>
                                                                </div>
                                                            </li>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">Automatic IFTA Reporting:</p>
                                                                <p class="usp-para">Eliminate audits and simplify tax compliance with automated reporting.</p>
                                                                </div>
                                                            </li>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">Live Vehicle Tracking and Alerts:</p>
                                                                <p class="usp-para">Monitor your fleet in real-time and receive alerts for missed stops or route changes.</p>
                                                                </div>
                                                            </li>

                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">Fully Customizable App:</p>
                                                                <p class="usp-para">Adjust settings like minimum gallons to fuel, add stops, and tailor the app to fit your needs.</p>
                                                                </div>
                                                            </li>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">Advanced Trip Planning and Analytics:</p>
                                                                <p class="usp-para">
                                                                    Utilize predictive fuel pricing, weather data, and vehicle performance insights for efficient route planning.
                                                                </p>
                                                                </div>
                                                            </li>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">API Integration with Admin Panel:</p>
                                                                <p class="usp-para">
                                                                    Seamlessly connect your software with ZeroIFTA, ensuring all truck, driver, and crucial fleet information is automatically shared and synced without manual input.
                                                                </p>
                                                                </div>
                                                            </li>
                                                            <li class="sbp-list mb-3">
                                                                <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="23" viewBox="0 0 26 23" fill="none">
                                                                    <path d="M6.26598 19.073C5.80585 19.073 5.41195 18.8989 5.08428 18.5508C4.75661 18.2026 4.59277 17.7841 4.59277 17.2952V4.85078C4.59277 4.36189 4.75661 3.94337 5.08428 3.59522C5.41195 3.24707 5.80585 3.073 6.26598 3.073H17.9784C18.0899 3.073 18.1945 3.08411 18.2921 3.10633C18.3897 3.12855 18.4873 3.16189 18.5849 3.20633L17.0372 4.85078H6.26598V17.2952H17.9784V11.3841L19.6516 9.60633V17.2952C19.6516 17.7841 19.4878 18.2026 19.1601 18.5508C18.8324 18.8989 18.4385 19.073 17.9784 19.073H6.26598ZM11.7248 15.5174L6.998 10.4952L8.16924 9.25078L11.7248 13.0286L19.4006 4.873L20.5928 6.09522L11.7248 15.5174Z" fill="#19A130" />
                                                                </svg>
                                                                </span>
                                                                <div>
                                                                <p class="usp-head">Special Yearly Rate: $995:</p>
                                                                <p class="usp-para">
                                                                    Secure the full suite of Premium+ features for a whole year and save over 15% compared to the monthly plan.
                                                                    Enjoy seamless integration, powerful analytics, and advanced tools designed to
                                                                    maximize your fleet's efficiency and keep your business running smoothly.
                                                                </p>
                                                                </div>
                                                            </li>
                                                            </ul>
                                                        </div>
                                                        </div>
                                                        <!-- Button -->
                                                        <div class="palns-btn mt-5">
                                                        <a href="{{route('buy','premium_plus_yearly')}}" class="mainBtn">
                                                            Buy Plan
                                                        </a>
                                                        </div>
                                                    </div>

                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


@endsection
@section('scripts')
<script>
  $("#plansSwitchCheckbox").on('change', function() {
    if ($(this).prop('checked')) {
      $("#yearly_plans").show();
      $("#monthly_plans").hide();
    } else {
      $("#yearly_plans").hide();
      $("#monthly_plans").show();
    }
  });
</script>
@endsection
