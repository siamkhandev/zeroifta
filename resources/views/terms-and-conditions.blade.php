<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous" />
  <!-- Custom Css -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
  <!-- Standard Favicon -->
  <link rel="icon" href="{{asset('assets/img/fav-icon.png')}}">

  <title>ZeroIfta</title>
</head>

<body>
  <div class="subs-PlansMain">
    <div class="container">
      <!-- Header Area -->
      <div class="header-main">
        <div>
          <div class="head-left">
            <svg xmlns="http://www.w3.org/2000/svg" width="162" height="45" viewBox="0 0 162 45" fill="none">
              <path d="M16.8035 10.0822V19.7442L26.4656 4.20093H2.52051V10.0822H16.8035Z" fill="#092E75" />
              <path d="M9.6623 29.8263L9.6623 20.1642L0.000253677 35.7075L23.9453 35.7075L23.9453 29.8263L9.6623 29.8263Z" fill="#092E75" />
              <path d="M37.4145 36.3938C35.3929 36.3938 33.6469 35.9737 32.1766 35.1336C30.715 34.2846 29.5904 33.0856 28.8027 31.5366C28.0151 29.9787 27.6212 28.1452 27.6212 26.036C27.6212 23.9618 28.0151 22.1414 28.8027 20.5749C29.5991 18.9995 30.7106 17.7743 32.1372 16.8991C33.5637 16.0152 35.2397 15.5732 37.1651 15.5732C38.4079 15.5732 39.5806 15.7745 40.6834 16.1771C41.7949 16.5709 42.7751 17.1835 43.624 18.015C44.4817 18.8464 45.1556 19.9054 45.6457 21.1919C46.1358 22.4696 46.3808 23.9925 46.3808 25.7603V27.2175H29.853V24.0143H41.8255C41.8167 23.1042 41.6198 22.2946 41.2347 21.5857C40.8497 20.8681 40.3114 20.3036 39.62 19.8922C38.9374 19.4809 38.141 19.2752 37.2308 19.2752C36.2593 19.2752 35.406 19.5115 34.6708 19.9841C33.9357 20.448 33.3624 21.0606 32.9511 21.822C32.5485 22.5747 32.3429 23.4017 32.3341 24.3032V27.0994C32.3341 28.2721 32.5485 29.2786 32.9774 30.1188C33.4062 30.9502 34.0057 31.5891 34.7759 32.0354C35.546 32.473 36.4475 32.6918 37.4802 32.6918C38.1716 32.6918 38.7973 32.5955 39.3575 32.403C39.9176 32.2017 40.4033 31.9085 40.8146 31.5234C41.226 31.1383 41.5367 30.6614 41.7467 30.0925L46.1839 30.5914C45.9038 31.7641 45.37 32.7881 44.5823 33.6633C43.8034 34.5297 42.8057 35.2036 41.5892 35.6849C40.3727 36.1575 38.9811 36.3938 37.4145 36.3938ZM50.4012 36V15.8357H55.009V19.1965H55.2191C55.5867 18.0325 56.2168 17.1354 57.1095 16.5053C58.0109 15.8664 59.0393 15.5469 60.1945 15.5469C60.4571 15.5469 60.7503 15.5601 61.0741 15.5863C61.4066 15.6038 61.6823 15.6344 61.9011 15.6782V20.0498C61.6998 19.9797 61.3804 19.9185 60.9428 19.866C60.514 19.8047 60.0982 19.7741 59.6957 19.7741C58.8292 19.7741 58.0503 19.9622 57.3589 20.3386C56.6763 20.7061 56.138 21.2181 55.7442 21.8745C55.3504 22.5309 55.1535 23.2879 55.1535 24.1456V36H50.4012ZM73.0236 36.3938C71.0545 36.3938 69.3479 35.9606 67.9038 35.0942C66.4597 34.2278 65.3395 33.0156 64.5431 31.4578C63.7554 29.9 63.3616 28.0796 63.3616 25.9966C63.3616 23.9137 63.7554 22.0889 64.5431 20.5224C65.3395 18.9558 66.4597 17.7393 67.9038 16.8728C69.3479 16.0064 71.0545 15.5732 73.0236 15.5732C74.9928 15.5732 76.6994 16.0064 78.1435 16.8728C79.5875 17.7393 80.7034 18.9558 81.491 20.5224C82.2875 22.0889 82.6857 23.9137 82.6857 25.9966C82.6857 28.0796 82.2875 29.9 81.491 31.4578C80.7034 33.0156 79.5875 34.2278 78.1435 35.0942C76.6994 35.9606 74.9928 36.3938 73.0236 36.3938ZM73.0499 32.5868C74.1176 32.5868 75.0103 32.2936 75.728 31.7072C76.4456 31.1121 76.9795 30.3157 77.3295 29.318C77.6884 28.3203 77.8678 27.2088 77.8678 25.9835C77.8678 24.7495 77.6884 23.6336 77.3295 22.6359C76.9795 21.6295 76.4456 20.8287 75.728 20.2335C75.0103 19.6384 74.1176 19.3409 73.0499 19.3409C71.9559 19.3409 71.0457 19.6384 70.3193 20.2335C69.6017 20.8287 69.0634 21.6295 68.7046 22.6359C68.3545 23.6336 68.1795 24.7495 68.1795 25.9835C68.1795 27.2088 68.3545 28.3203 68.7046 29.318C69.0634 30.3157 69.6017 31.1121 70.3193 31.7072C71.0457 32.2936 71.9559 32.5868 73.0499 32.5868Z" fill="#092E75" />
              <path d="M142.244 36.1276H137.045L146.51 9.24194H152.523L162.001 36.1276H156.802L149.621 14.7556H149.411L142.244 36.1276ZM142.414 25.586H156.592V29.4981H142.414V25.586Z" fill="#092E75" />
              <path d="M116.454 13.3247V9.24194H137.905V13.3247H129.595V36.1276H124.764V13.3247H116.454Z" fill="#092E75" />
              <path d="M95.9746 36.1276V9.24194H114.879V13.3247H100.845V20.6237H117.898V24.7065H100.845V36.1276H95.9746Z" fill="#092E75" />
              <path d="M90.7005 9.24194V36.1276H85.8301V9.24194H90.7005Z" fill="#092E75" />
            </svg>
          </div>
        </div>
        <div class="right-opts">
          <div class="head-right">
            
            <div class="opt-div">
              <div class="mob-menu">
                <div class="mobLogo-div">
                  <img src="assets/img/logo-blue.png" alt="ZeroIfta Logo">
                </div>
              </div>
              <div class="menu-opt">
                <div id="dark-themeIcon" class="dark-themeIcon hf-svg">
                  <svg xmlns="http://www.w3.org/2000/svg" width="17" height="18" viewBox="0 0 17 18" fill="none">
                    <path d="M9 18C11.776 18 14.3114 16.737 15.9911 14.6675C16.2396 14.3613 15.9686 13.9141 15.5846 13.9872C11.2181 14.8188 7.20819 11.4709 7.20819 7.06303C7.20819 4.52398 8.5674 2.18914 10.7765 0.931992C11.117 0.738211 11.0314 0.221941 10.6444 0.150469C10.102 0.0504468 9.55158 8.21369e-05 9 0C4.03211 0 0 4.02578 0 9C0 13.9679 4.02578 18 9 18Z" fill=""></path>
                  </svg>
                </div>
                <div id="light-themeIcon" class="light-themeIcon hf-svg" style="display: none">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M11 4V1H13V4H11ZM11 23V20H13V23H11ZM20 13V11H23V13H20ZM1 13V11H4V13H1ZM18.7 6.7L17.3 5.3L19.05 3.5L20.5 4.95L18.7 6.7ZM4.95 20.5L3.5 19.05L5.3 17.3L6.7 18.7L4.95 20.5ZM19.05 20.5L17.3 18.7L18.7 17.3L20.5 19.05L19.05 20.5ZM5.3 6.7L3.5 4.95L4.95 3.5L6.7 5.3L5.3 6.7ZM12 18C10.3333 18 8.91667 17.4167 7.75 16.25C6.58333 15.0833 6 13.6667 6 12C6 10.3333 6.58333 8.91667 7.75 7.75C8.91667 6.58333 10.3333 6 12 6C13.6667 6 15.0833 6.58333 16.25 7.75C17.4167 8.91667 18 10.3333 18 12C18 13.6667 17.4167 15.0833 16.25 16.25C15.0833 17.4167 13.6667 18 12 18ZM12 16C13.1167 16 14.0625 15.6125 14.8375 14.8375C15.6125 14.0625 16 13.1167 16 12C16 10.8833 15.6125 9.9375 14.8375 9.1625C14.0625 8.3875 13.1167 8 12 8C10.8833 8 9.9375 8.3875 9.1625 9.1625C8.3875 9.9375 8 10.8833 8 12C8 13.1167 8.3875 14.0625 9.1625 14.8375C9.9375 15.6125 10.8833 16 12 16Z" fill=""></path>
                  </svg>
                </div>
                <div class="hf-svg">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" viewBox="0 0 16 20" fill="none">
                    <path d="M15.2901 15.29L14.0001 14V9C14.0001 5.93 12.3601 3.36 9.50005 2.68V2C9.50005 1.17 8.83005 0.5 8.00005 0.5C7.17005 0.5 6.50005 1.17 6.50005 2V2.68C3.63005 3.36 2.00005 5.92 2.00005 9V14L0.710051 15.29C0.0800515 15.92 0.520051 17 1.41005 17H14.5801C15.4801 17 15.9201 15.92 15.2901 15.29ZM12.0001 15H4.00005V9C4.00005 6.52 5.51005 4.5 8.00005 4.5C10.4901 4.5 12.0001 6.52 12.0001 9V15ZM8.00005 20C9.10005 20 10.0001 19.1 10.0001 18H6.00005C6.00005 19.1 6.89005 20 8.00005 20Z" fill=""></path>
                  </svg>
                </div>
                <div class="up-img">
                <div class="dropdown">
                @if(Auth::user() && Auth::user()->image)
                <img src="{{asset('images')}}/{{Auth::user()->image}}" alt="ZeroIfta Image" onclick="toggleDropdown()" style="height: 30px;border-radius:100%" />
                @else
                <img src="{{asset('assets/img/user-img.png')}}" alt="ZeroIfta Image" onclick="toggleDropdown()" />
                @endif
                <!-- <img src="user_image_url.jpg" onclick="toggleDropdown()" class="dropbtn" alt="User"> -->

              </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Subscription Row -->
      <div class="user-subsPlnas">
        <div class="usp_inn">
          <div class="manage-comp mb-4">
            <div class="Filters-main mb-3 mb-md-4">
              <div class="sec1-style">
                <div class="subs_plan">
                  <div class="inHead-span">
                    <h2 class="head-20Med">Terms and conditions</h2>
                  </div>
                  <div class="row">

                    <div class="col-md-12">
                        <h2>AGREEMENT TO OUR LEGAL TERMS</h2>
                        <p>We are ZeroIFTA, a company registered in Wyoming, United States at 12 W. 2nd St #4324, Casper, WY 82601.

We operate the mobile application ZeroIFTA, as well as any other related products and services that refer to or link to these legal terms.

ZeroIFTA is a mobile app to help truck drivers avoid fines and use the fuel taxes in their favor.

You can contact us by phone at 1-800 594 7086, email at contact@zeroifta.com, or by mail to 12 W. 2nd St #4324, Casper, WY 82601, United States.

These Legal Terms constitute a legally binding agreement made between you, whether personally or on behalf of an entity, and ZeroIFTA, concerning your access to and use of the Services. You agree that by accessing the Services, you have read, understood, and agreed to be bound by all these Legal Terms. IF YOU DO NOT AGREE WITH ALL OF THESE LEGAL TERMS, THEN YOU ARE EXPRESSLY PROHIBITED FROM USING THE SERVICES AND YOU MUST DISCONTINUE USE IMMEDIATELY.

We will provide you with prior notice of any scheduled changes to the Services you are using. The modified Legal Terms will become effective upon posting or notifying you by __________, as stated in the email message. By continuing to use the Services after the effective date of any changes, you agree to be bound by the modified terms.</p>
<p>All users who are minors in the jurisdiction in which they reside (generally under the age of 18) must have permission of, and be directly supervised by, their parent or guardian to use the Services. If you are a minor, you must have your parent or guardian read and agree to these Legal Terms prior to you using the Services.

We recommend that you print a copy of these Legal Terms for your records.</p>
<h2>TABLE OF CONTENTS</h2>
<ul>
    <li>OUR SERVICES</li>
    <li>INTELLECTUAL PROPERTY RIGHTS</li>
    <li>USER REPRESENTATIONS</li>
    <li>USER REGISTRATION</li>
    <li>PROHIBITED ACTIVITIES</li>
    <li>USER GENERATED CONTRIBUTIONS</li>
    <li>CONTRIBUTION LICENSE</li>
    <li>GUIDELINES FOR REVIEWS</li>
    <li>MOBILE APPLICATION LICENSE</li>
    <li>SOCIAL MEDIA</li>
    <li>THIRD-PARTY WEBSITES AND CONTENT</li>
    <li>SERVICES MANAGEMENT</li>
    <li>TERM AND TERMINATION</li>
    <li>MODIFICATIONS AND INTERRUPTIONS</li>
    <li>GOVERNING LAW</li>
    <li>DISPUTE RESOLUTION</li>
    <li>CORRECTIONS</li>
    <li>DISCLAIMER</li>
    <li>LIMITATIONS OF LIABILITY</li>
    <li>INDEMNIFICATION</li>
    <li>USER DATA</li>
    <li>ELECTRONIC COMMUNICATIONS, TRANSACTIONS, AND SIGNATURES</li>
    <li>CALIFORNIA USERS AND RESIDENTS</li>
    <li>MISCELLANEOUS</li>
    <li>CONTACT US</li>

</ul>
<h2>OUR SERVICES</h2>
<p>The information provided when using the Services is not intended for distribution to or use by any person or entity in any jurisdiction or country where such distribution or use would be contrary to law or regulation or which would subject us to any registration requirement within such jurisdiction or country. Accordingly, those persons who choose to access the Services from other locations do so on their own initiative and are solely responsible for compliance with local laws, if and to the extent local laws are applicable.</p>
<p>The Services are not tailored to comply with industry-specific regulations (Health Insurance Portability and Accountability Act (HIPAA), Federal Information Security Management Act (FISMA), etc.), so if your interactions would be subjected to such laws, you may not use the Services. You may not use the Services in a way that would violate the Gramm-Leach-Bliley Act (GLBA).</p>
<h2>INTELLECTUAL PROPERTY RIGHTS</h2>
<h3>Our intellectual property</h3>
<p>We are the owner or the licensee of all intellectual property rights in our Services, including all source code, databases, functionality, software, website designs, audio, video, text, photographs, and graphics in the Services (collectively, the “Content”), as well as the trademarks, service marks, and logos contained therein (the “Marks”).</p>
<p>Our Content and Marks are protected by copyright and trademark laws (and various other intellectual property rights and unfair competition laws) and treaties in the United States and around the world.</p>
<p>The Content and Marks are provided in or through the Services “AS IS” for your personal, non-commercial use or internal business purpose only.</p>
<h3>Your use of our Services</h3>
<p>Subject to your compliance with these Legal Terms, including the “PROHIBITED ACTIVITIES” section below, we grant you a non-exclusive, non-transferable, revocable license to:</p>
<p>
access the Services; and
download or print a copy of any portion of the Content to which you have properly gained access.
solely for your personal, non-commercial use or internal business purpose.
</p>
<p>Except as set out in this section or elsewhere in our Legal Terms, no part of the Services and no Content or Marks may be copied, reproduced, aggregated, republished, uploaded, posted, publicly displayed, encoded, translated, transmitted, distributed, sold, licensed, or otherwise exploited for any commercial purpose whatsoever, without our express prior written permission.</p>
<p>If you wish to make any use of the Services, Content, or Marks other than as set out in this section or elsewhere in our Legal Terms, please address your request to:</p>
<p>zeroifta@srdlg.com. If we ever grant you the permission to post, reproduce, or publicly display any part of our Services or Content, you must identify us as the owners or licensors of the Services, Content, or Marks and ensure that any copyright or proprietary notice appears or is visible on posting, reproducing, or displaying our Content.</p>
<p>We reserve all rights not expressly granted to you in and to the Services, Content, and Marks.Any breach of these Intellectual Property Rights will constitute a material breach of our Legal Terms and your right to use our Services will terminate immediately.</p>
<h3>Your submissions</h3>
<p>Please review this section and the “PROHIBITED ACTIVITIES” section carefully prior to using our Services to understand the (a) rights you give us and (b) obligations you have when you post or upload any content through the Services.</p>
<p>Submissions: By directly sending us any question, comment, suggestion, idea, feedback, or other information about the Services (“Submissions”), you agree to assign to us all intellectual property rights in such Submission. You agree that we shall own this Submission and be entitled to its unrestricted use and dissemination for any lawful purpose, commercial or otherwise, without acknowledgment or compensation to you.</p>
<p>You are responsible for what you post or upload: By sending us Submissions through any part of the Services you:</p>
<p>confirm that you have read and agree with our “PROHIBITED ACTIVITIES “and will not post, send, publish, upload, or transmit through the Services any Submission that is illegal, harassing, hateful, harmful, defamatory, obscene, bullying, abusive, discriminatory, threatening to any person or group, sexually explicit, false, inaccurate, deceitful, or misleading;
to the extent permissible by applicable law, waive any and all moral rights toany such Submission;
warrant that any such Submission are original to you or that you have thenecessary rights and licenses to submit such Submissions and that you havefull authority to grant us the above-mentioned rights in relation to yourSubmissions; and
warrant and represent that your Submissions do not constitute confidentialinformation.</p>
<p>You are solely responsible for your Submissions and you expressly agree to reimburse us for any and all losses that we may suffer because of your breach of (a) this section, (b) any third party’s intellectual property rights, or (c) applicable law.</p>
<h2>USER REPRESENTATIONS</h2>
<p>By using the Services, you represent and warrant that: (1) all registration information you submit will be true, accurate, current, and complete; (2) you will maintain the accuracy of such information and promptly update such registration information as necessary; (3) you have the legal capacity and you agree to comply with these Legal Terms; (4) you are not a minor in the jurisdiction in which you reside, or if a minor, you have received parental permission to use the Services; (5) you will not access the Services through automated or non-human means, whether through a bot, script or otherwise; (6) you will not use the Services for any illegal or unauthorized purpose; and (7) your use of the Services will not violate any applicable law or regulation.</p>
<p>If you provide any information that is untrue, inaccurate, not current, or incomplete, we have the right to suspend or terminate your account and refuse any and all current or future use of the Services (or any portion thereof).</p>
<h2>USER REGISTRATION</h2>
<p>
You may be required to register to use the Services. You agree to keep your password confidential and will be responsible for all use of your account and password. We reserve the right to remove, reclaim, or change a username you select if we determine, in our sole discretion, that such username is inappropriate, obscene, or otherwise objectionable.
</p>
<h2>PROHIBITED ACTIVITIES</h2>
<p>You may not access or use the Services for any purpose other than that for which we make the Services available. The Services may not be used in connection with any commercial endeavors except those that are specifically endorsed or approved by us.

As a user of the Services, you agree not to:</p>
<p>Systematically retrieve data or other content from the Services to create orcompile, directly or indirectly, a collection, compilation, database, or directorywithout written permission from us.
Trick, defraud, or mislead us and other users, especially in any attempt to learnsensitive account information such as user passwords.
Circumvent, disable, or otherwise interfere with security-related features of theServices, including features that prevent or restrict the use or copying of anyContent or enforce limitations on the use of the Services and/or the Contentcontained therein.
Disparage, tarnish, or otherwise harm, in our opinion, us and/or the Services.
Use any information obtained from the Services in order to harass, abuse, orharm another person.
Make improper use of our support services or submit false reports of abuse ormisconduct.
Use the Services in a manner inconsistent with any applicable laws orregulations.
Engage in unauthorized framing of or linking to the Services.</p>
<p>Upload or transmit (or attempt to upload or to transmit) viruses, Trojan horses,or other material, including excessive use of capital letters and spamming(continuous posting of repetitive text), that interferes with any party’suninterrupted use and enjoyment of the Services or modifies, impairs, disrupts,alters, or interferes with the use, features, functions, operation, or maintenanceof the Services.
Engage in any automated use of the system, such as using scripts to sendcomments or messages, or using any data mining, robots, or similar datagathering and extraction tools.
Delete the copyright or other proprietary rights notice from any Content.
Attempt to impersonate another user or person or use the username ofanother user.</p>
<p>Upload or transmit (or attempt to upload or to transmit) any material that actsas a passive or active information collection or transmission mechanism,including without limitation, clear graphics interchange formats (“gifs”), 1×1pixels, web bugs, cookies, or other similar devices (sometimes referred to as”spyware” or “passive collection mechanisms” or “pcms”).
Interfere with, disrupt, or create an undue burden on the Services or thenetworks or services connected to the Services.
Harass, annoy, intimidate, or threaten any of our employees or agentsengaged in providing any portion of the Services to you.
Attempt to bypass any measures of the Services designed to prevent orrestrict access to the Services, or any portion of the Services.
Copy or adapt the Services’ software, including but not limited to Flash, PHP,HTML, JavaScript, or other code.
Except as permitted by applicable law, decipher, decompile, disassemble, orreverse engineer any of the software comprising or in any way making up apart of the Services.</p>
<p>Except as may be the result of standard search engine or Internet browserusage, use, launch, develop, or distribute any automated system, includingwithout limitation, any spider, robot, cheat utility, scraper, or offline reader thataccesses the Services, or use or launch any unauthorized script or othersoftware.
Use a buying agent or purchasing agent to make purchases on the Services.
Make any unauthorized use of the Services, including collecting usernamesand/or email addresses of users by electronic or other means for the purposeof sending unsolicited email, or creating user accounts by automated means orunder false pretenses.
Use the Services as part of any effort to compete with us or otherwise use theServices and/or the Content for any revenue-generating endeavor orcommercial enterprise.
Use the Services to advertise or offer to sell goods and services.</p>
<h2>USER GENERATED CONTRIBUTIONS</h2>
<p>The Services does not offer users to submit or post content. We may provide youwith the opportunity to create, submit, post, display, transmit, perform, publish,distribute, or broadcast content and materials to us or on the Services, including butnot limited to text, writings, video, audio, photographs, graphics, comments,suggestions, or personal information or other material (collectively, “Contributions”).Contributions may be viewable by other users of the Services and through third-partywebsites. As such, any Contributions you transmit may be treated in accordance withthe Services’ Privacy Policy. When you create or make available any Contributions,you thereby represent and warrant that:</p>
<p>The creation, distribution, transmission, public display, or performance, and theaccessing, downloading, or copying of your Contributions do not and will notinfringe the proprietary rights, including but not limited to the copyright, patent,trademark, trade secret, or moral rights of any third party.
You are the creator and owner of or have the necessary licenses, rights,consents, releases, and permissions to use and to authorize us, the Services,and other users of the Services to use your Contributions in any mannercontemplated by the Services and these Legal Terms.
You have the written consent, release, and/or permission of each and everyidentifiable individual person in your Contributions to use the name or likenessof each and every such identifiable individual person to enable inclusion anduse of your Contributions in any manner contemplated by the Services andthese Legal Terms.</p>
<p>Your Contributions are not false, inaccurate, or misleading.
Your Contributions are not unsolicited or unauthorized advertising, promotionalmaterials, pyramid schemes, chain letters, spam, mass mailings, or otherforms of solicitation.
Your Contributions are not obscene, lewd, lascivious, filthy, violent, harassing,libelous, slanderous, or otherwise objectionable (as determined by us).
Your Contributions do not ridicule, mock, disparage, intimidate, or abuseanyone.
Your Contributions are not used to harass or threaten (in the legal sense ofthose terms) any other person and to promote violence against a specificperson or class of people.</p>
<p>Your Contributions do not violate any applicable law, regulation, or rule.
Your Contributions do not violate the privacy or publicity rights of any thirdparty.
Your Contributions do not violate any applicable law concerning childpornography, or otherwise intended to protect the health or well-being ofminors.</p>
<p>Any use of the Services in violation of the foregoing violates these Legal Terms and may result in, among other things, termination, or suspension of your rights to use the Services.</p>
<h2>CONTRIBUTION LICENSE</h2>
<p>You and Services agree that we may access, store, process, and use any informationand personal data that you provide following the terms of the Privacy Policy and yourchoices (including settings).

By submitting suggestions or other feedback regarding the Services, you agree thatwe can use and share such feedback for any purpose without compensation to you.</p>
<p>We do not assert any ownership over your Contributions. You retain full ownership ofall of your Contributions and any intellectual property rights or other proprietary rightsassociated with your Contributions. We are not liable for any statements orrepresentations in your Contributions provided by you in any area on the Services.You are solely responsible for your Contributions to the Services and you expresslyagree to exonerate us from any and all responsibility and to refrain from any legalaction against us regarding your Contributions.</p>
<h2>GUIDELINES FOR REVIEWS</h2>
<p>We may provide you areas on the Services to leave reviews or ratings. When posting a review, you must comply with the following criteria: (1) you should have firsthand experience with the person/entity being reviewed; (2) your reviews should not contain offensive profanity, or abusive, racist, offensive, or hateful language; (3) your reviews should not contain discriminatory references based on religion, race, gender, national origin, age, marital status, sexual orientation, or disability; (4) your reviews should not contain references to illegal activity; (5) you should not be affiliated with competitors if posting negative reviews; (6) you should not make any conclusions as to the legality of conduct; (7) you may not post any false or misleading statements; and (8) you may not organize a campaign encouraging others to post reviews, whether positive or negative.</p>
<p>We may accept, reject, or remove reviews in our sole discretion. We have absolutely no obligation to screen reviews or to delete reviews, even if anyone considers reviews objectionable or inaccurate. Reviews are not endorsed by us, and do not necessarily represent our opinions or the views of any of our affiliates or partners. We do not assume liability for any review or for any claims, liabilities, or losses resulting from any review. By posting a review, you hereby grant to us a perpetual, nonexclusive, worldwide, royalty-free, fully paid, assignable, and sublicensable right and license to reproduce, modify, translate, transmit by any means, display, perform, and/or distribute all content relating to review.</p>
<h2>MOBILE APPLICATION LICENSE</h2>
<h3>Use License</h3>
<p>If you access the Services via the App, then we grant you a revocable, non-exclusive, non-transferable, limited right to install and use the App on wireless electronic devices owned or controlled by you, and to access and use the App on such devices strictly in accordance with the terms and conditions of this mobile application license contained in these Legal Terms. You shall not: (1) except as permitted by applicable law, decompile, reverse engineer, disassemble, attempt to derive the source code of, or decrypt the App; (2) make any modification, adaptation, improvement, enhancement, translation, or derivative work from the App; (3) violate any applicable laws, rules, or regulations in connection with your access or use of the App; (4) remove, alter, or obscure any proprietary notice (including any notice of copyright or trademark) posted by us or the licensors of the App; (5) use the App for any revenuegenerating endeavor, commercial enterprise, or other purpose for which it is not designed or intended; (6) make the App available over a network or other environment permitting access or use by multiple devices or users at the same time; (7) use the App for creating a product, service, or software that is, directly or indirectly, competitive with or in any way a substitute for the App; (8) use the App to send automated queries to any website or to send any unsolicited commercial email; or (9) use any proprietary information or any of our interfaces or our other intellectual property in the design, development, manufacture, licensing, or distribution of any applications, accessories, or devices for use with the App.</p>
<h3>Apple and Android Devices</h3>
<p>The following terms apply when you use the App obtained from either the Apple Store or Google Play (each an “App Distributor”) to access the Services: (1) the license granted to you for our App is limited to a non-transferable license to use the application on a device that utilizes the Apple iOS or Android operating systems, as applicable, and in accordance with the usage rules set forth in the applicable App Distributor’s terms of service; (2) we are responsible for providing any maintenance and support services with respect to the App as specified in the terms and conditions of this mobile application license contained in these Legal Terms or as otherwise required under applicable law, and you acknowledge that each App Distributor has no obligation whatsoever to furnish any maintenance and support services with respect to the App; (3) in the event of any failure of the App to conform to any applicable warranty, you may notify the applicable App Distributor, and the App Distributor, in accordance with its terms and policies, may refund the purchase price, if any, paid for the App, and to the maximum extent permitted by applicable law, the App Distributor will have no other warranty obligation whatsoever with respect to the App; (4) you represent and warrant that (i) you are not located in a country that is subject to a US

government embargo, or that has been designated by the US government as a “terrorist supporting” country and (ii) you are not listed on any US government list of prohibited or restricted parties; (5) you must comply with applicable third-party terms of agreement when using the App, e.g., if you have a VoIP application, then you must not be in violation of their wireless data service agreement when using the App; and (6) you acknowledge and agree that the App Distributors are third-party beneficiaries of the terms and conditions in this mobile application license contained in these Legal Terms, and that each App Distributor will have the right (and will be deemed to have accepted the right) to enforce the terms and conditions in this mobile application license contained in these Legal Terms against you as a third-party beneficiary thereof.</p>
<h2>SOCIAL MEDIA</h2>
<p>As part of the functionality of the Services, you may link your account with online accounts you have with third-party service providers (each such account, a “ThirdParty Account”) by either: (1) providing your Third-Party Account login information through the Services; or (2) allowing us to access your Third-Party Account, as is permitted under the applicable terms and conditions that govern your use of each Third-Party Account. You represent and warrant that you are entitled to disclose your

Third-Party Account login information to us and/or grant us access to your Third-Party Account, without breach by you of any of the terms and conditions that govern your use of the applicable Third-Party Account, and without obligating us to pay any fees or making us subject to any usage limitations imposed by the third-party service provider of the Third-Party Account. </p>
<p>
By granting us access to any Third-Party Accounts, you understand that (1) we may access, make available, and store (if applicable) any content that you have provided to and stored in your Third-Party

Account (the “Social Network Content”) so that it is available on and through the Services via your account, including without limitation any friend lists and (2) we may submit to and receive from your Third-Party Account additional information to the extent you are notified when you link your account with the Third-Party Account. Depending on the Third-Party Accounts you choose and subject to the privacy settings that you have set in such Third-Party Accounts, personally identifiable information that you post to your Third-Party Accounts may be available on and through your account on the Services. Please note that if a Third-Party Account or associated service becomes unavailable or our access to such Third-Party Account is terminated by the third-party service provider, then Social Network Content may no longer be available on and through the Services. You will have the ability to disable the connection between your account on the Services and your Third-Party Accounts at any time. PLEASE NOTE THAT YOUR RELATIONSHIP WITH THE THIRDPARTY SERVICE PROVIDERS ASSOCIATED WITH YOUR THIRD-PARTY ACCOUNTS IS GOVERNED SOLELY BY YOUR AGREEMENT(S) WITH SUCH

THIRD-PARTY SERVICE PROVIDERS.
</p>
<p>We make no effort to review any Social

Network Content for any purpose, including but not limited to, for accuracy, legality, or non-infringement, and we are not responsible for any Social Network Content. You acknowledge and agree that we may access your email address book associated with a Third-Party Account and your contacts list stored on your mobile device or tablet computer solely for purposes of identifying and informing you of those contacts who have also registered to use the Services. You can deactivate the connection between the Services and your Third-Party Account by contacting us using the contact information below or through your account settings (if applicable). We will attempt to delete any information stored on our servers that was obtained through such Third-Party Account, except the username and profile picture that become associated with your account.></p>
<h2>THIRD-PARTY WEBSITES AND CONTENT</h2>
<p>The Services may contain (or you may be sent via the App) links to other websites (“Third-Party Websites”) as well as articles, photographs, text, graphics, pictures, designs, music, sound, video, information, applications, software, and other content or items belonging to or originating from third parties (“Third-Party Content”). Such Third-Party Websites and Third-Party Content are not investigated, monitored, or checked for accuracy, appropriateness, or completeness by us, and we are not responsible for any Third-Party Websites accessed through the Services or any Third-Party Content posted on, available through, or installed from the Services, including the content, accuracy, offensiveness, opinions, reliability, privacy practices, or other policies of or contained in the Third-Party Websites or the Third-Party Content. Inclusion of, linking to, or permitting the use or installation of any Third-Party Websites or any Third-Party Content does not imply approval or endorsement thereof

by us. If you decide to leave the Services and access the Third-Party Websites or to use or install any Third-Party Content, you do so at your own risk, and you should be aware these Legal Terms no longer govern.</p>
<p>You should review the applicable terms and policies, including privacy and data gathering practices, of any website to which you navigate from the Services or relating to any applications you use or install from the Services. Any purchases you make through Third-Party Websites will be through other websites and from other companies, and we take no responsibility whatsoever in relation to such purchases which are exclusively between you and the applicable third party. You agree and acknowledge that we do not endorse the products or services offered on Third-Party Websites and you shall hold us blameless from any harm caused by your purchase of such products or services. Additionally, you shall hold us blameless from any losses sustained by you or harm caused to you relating to or resulting in any way from any Third-Party Content or any contact with ThirdParty Websites.</p>
<h2>SERVICES MANAGEMENT</h2>
<p>We reserve the right, but not the obligation, to: (1) monitor the Services for violations of these Legal Terms; (2) take appropriate legal action against anyone who, in our sole discretion, violates the law or these Legal Terms, including without limitation, reporting such user to law enforcement authorities; (3) in our sole discretion and without limitation, refuse, restrict access to, limit the availability of, or disable (to the extent technologically feasible) any of your Contributions or any portion thereof; (4) in our sole discretion and without limitation, notice, or liability, to remove from the Services or otherwise disable all files and content that are excessive in size or are in any way burdensome to our systems; and (5) otherwise manage the Services in a manner designed to protect our rights and property and to facilitate the proper functioning of the Services.</p>
<h2>PRIVACY POLICY</h2>
<p>We care about data privacy and security. Please review our Privacy Policy: __________. By using the Services, you agree to be bound by our Privacy Policy, which is incorporated into these Legal Terms. Please be advised the Services are hosted in the United States. If you access the Services from any other region of the world with laws or other requirements governing personal data collection, use, or disclosure that differ from applicable laws in the United States, then through your continued use of the Services, you are transferring your data to the United States, and you expressly consent to have your data transferred to and processed in the United States.</p>
<h2>TERM AND TERMINATION</h2>
<p>These Legal Terms shall remain in full force and effect while you use the Services.</p>
<p>WITHOUT LIMITING ANY OTHER PROVISION OF THESE LEGAL TERMS, WE

RESERVE THE RIGHT TO, IN OUR SOLE DISCRETION AND WITHOUT NOTICE

OR LIABILITY, DENY ACCESS TO AND USE OF THE SERVICES (INCLUDING

BLOCKING CERTAIN IP ADDRESSES), TO ANY PERSON FOR ANY REASON OR

FOR NO REASON, INCLUDING WITHOUT LIMITATION FOR BREACH OF ANY

REPRESENTATION, WARRANTY, OR COVENANT CONTAINED IN THESE LEGAL

TERMS OR OF ANY APPLICABLE LAW OR REGULATION. WE MAY TERMINATE

YOUR USE OR PARTICIPATION IN THE SERVICES OR DELETE YOUR ACCOUNT AND ANY CONTENT OR INFORMATION THAT YOU POSTED AT ANY TIME, WITHOUT WARNING, IN OUR SOLE DISCRETION.</p>
<p>If we terminate or suspend your account for any reason, you are prohibited from registering and creating a new account under your name, a fake or borrowed name, or the name of any third party, even if you may be acting on behalf of the third party. In addition to terminating or suspending your account, we reserve the right to take appropriate legal action, including without limitation pursuing civil, criminal, and injunctive redress.</p>
<h2>MODIFICATIONS AND INTERRUPTIONS</h2>
<p>We reserve the right to change, modify, or remove the contents of the Services at any time or for any reason at our sole discretion without notice. However, we have no obligation to update any information on our Services. We will not be liable to you or

any third party for any modification, price change, suspension, or discontinuance of the Services.</p>
<p>We cannot guarantee the Services will be available at all times. We may experience hardware, software, or other problems or need to perform maintenance related to the Services, resulting in interruptions, delays, or errors. We reserve the right to change, revise, update, suspend, discontinue, or otherwise modify the Services at any time or for any reason without notice to you. You agree that we have no liability whatsoever for any loss, damage, or inconvenience caused by your inability to access or use the Services during any downtime or discontinuance of the Services. Nothing in these Legal Terms will be construed to obligate us to maintain and support the Services or to supply any corrections, updates, or releases in connection therewith.</p>
<h2>GOVERNING LAW</h2>
<p>These Legal Terms and your use of the Services are governed by and construed in accordance with the laws of the State of Wyoming applicable to agreements made and to be entirely performed within the State of Wyoming, without regard to its conflict of law principles</p>
<h2>DISPUTE RESOLUTION</h2>
<p>Any legal action of whatever nature brought by either you or us (collectively, the “Parties” and individually, a “Party”) shall be commenced or prosecuted in the state and federal courts located in United States , Wyoming, and the Parties hereby consent to, and waive all defenses of lack of personal jurisdiction and forum non conveniens with respect to venue and jurisdiction in such state and federal courts. Application of the United Nations Convention on Contracts for the International Sale of Goods and the Uniform Computer Information Transaction Act (UCITA) are excluded from these Legal Terms. In no event shall any claim, action, or proceeding brought by either Party related in any way to the Services be commenced more than one (1) years after the cause of action arose.</p>
<h2>CORRECTIONS</h2>
<p>There may be information on the Services that contains typographical errors, inaccuracies, or omissions, including descriptions, pricing, availability, and various other information. We reserve the right to correct any errors, inaccuracies, or omissions and to change or update the information on the Services at any time, without prior notice.</p>
<h2>DISCLAIMER</h2>
<p>THE SERVICES ARE PROVIDED ON AN AS-IS AND AS-AVAILABLE BASIS. YOU

AGREE THAT YOUR USE OF THE SERVICES WILL BE AT YOUR SOLE RISK. TO

THE FULLEST EXTENT PERMITTED BY LAW, WE DISCLAIM ALL WARRANTIES,

EXPRESS OR IMPLIED, IN CONNECTION WITH THE SERVICES AND YOUR USE

THEREOF, INCLUDING, WITHOUT LIMITATION, THE IMPLIED WARRANTIES OF

MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NONINFRINGEMENT. WE MAKE NO WARRANTIES OR REPRESENTATIONS ABOUT

THE ACCURACY OR COMPLETENESS OF THE SERVICES’ CONTENT OR THE

CONTENT OF ANY WEBSITES OR MOBILE APPLICATIONS LINKED TO THE

SERVICES AND WE WILL ASSUME NO LIABILITY OR RESPONSIBILITY FOR

ANY (1) ERRORS, MISTAKES, OR INACCURACIES OF CONTENT AND

MATERIALS, (2) PERSONAL INJURY OR PROPERTY DAMAGE, OF ANY NATURE

WHATSOEVER, RESULTING FROM YOUR ACCESS TO AND USE OF THE

SERVICES, (3) ANY UNAUTHORIZED ACCESS TO OR USE OF OUR SECURE

SERVERS AND/OR ANY AND ALL PERSONAL INFORMATION AND/OR

FINANCIAL INFORMATION STORED THEREIN, (4) ANY INTERRUPTION OR

CESSATION OF TRANSMISSION TO OR FROM THE SERVICES, (5) ANY BUGS,

VIRUSES, TROJAN HORSES, OR THE LIKE WHICH MAY BE TRANSMITTED TO

OR THROUGH THE SERVICES BY ANY THIRD PARTY, AND/OR (6) ANY ERRORS

OR OMISSIONS IN ANY CONTENT AND MATERIALS OR FOR ANY LOSS OR

DAMAGE OF ANY KIND INCURRED AS A RESULT OF THE USE OF ANY

CONTENT POSTED, TRANSMITTED, OR OTHERWISE MADE AVAILABLE VIA

THE SERVICES. WE DO NOT WARRANT, ENDORSE, GUARANTEE, OR ASSUME

RESPONSIBILITY FOR ANY PRODUCT OR SERVICE ADVERTISED OR

OFFERED BY A THIRD PARTY THROUGH THE SERVICES, ANY HYPERLINKED

WEBSITE, OR ANY WEBSITE OR MOBILE APPLICATION FEATURED IN ANY

BANNER OR OTHER ADVERTISING, AND WE WILL NOT BE A PARTY TO OR IN

ANY WAY BE RESPONSIBLE FOR MONITORING ANY TRANSACTION BETWEEN

YOU AND ANY THIRD-PARTY PROVIDERS OF PRODUCTS OR SERVICES. AS

WITH THE PURCHASE OF A PRODUCT OR SERVICE THROUGH ANY MEDIUM

OR IN ANY ENVIRONMENT, YOU SHOULD USE YOUR BEST JUDGMENT AND EXERCISE CAUTION WHERE APPROPRIATE.</p>
<h2>LIMITATIONS OF LIABILITY</h2>
<p>IN NO EVENT WILL WE OR OUR DIRECTORS, EMPLOYEES, OR AGENTS BE

LIABLE TO YOU OR ANY THIRD PARTY FOR ANY DIRECT, INDIRECT,

CONSEQUENTIAL, EXEMPLARY, INCIDENTAL, SPECIAL, OR PUNITIVE

DAMAGES, INCLUDING LOST PROFIT, LOST REVENUE, LOSS OF DATA, OR OTHER DAMAGES ARISING FROM YOUR USE OF THE SERVICES, EVEN IF WE HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.

NOTWITHSTANDING ANYTHING TO THE CONTRARY CONTAINED HEREIN,

OUR LIABILITY TO YOU FOR ANY CAUSE WHATSOEVER AND REGARDLESS

OF THE FORM OF THE ACTION, WILL AT ALL TIMES BE LIMITED TO THE

LESSER OF THE AMOUNT PAID, IF ANY, BY YOU TO US DURING THE SIX (6) MONTH PERIOD PRIOR TO ANY CAUSE OF ACTION ARISING OR $180.00

USD. CERTAIN US STATE LAWS AND INTERNATIONAL LAWS DO NOT ALLOW

LIMITATIONS ON IMPLIED WARRANTIES OR THE EXCLUSION OR LIMITATION

OF CERTAIN DAMAGES. IF THESE LAWS APPLY TO YOU, SOME OR ALL OF THE ABOVE DISCLAIMERS OR LIMITATIONS MAY NOT APPLY TO YOU, AND YOU MAY HAVE ADDITIONAL RIGHTS.</p>
<h2>INDEMNIFICATION</h2>
<p>You agree to defend, indemnify, and hold us harmless, including our subsidiaries, affiliates, and all of our respective officers, agents, partners, and employees, from and against any loss, damage, liability, claim, or demand, including reasonable attorneys’ fees and expenses, made by any third party due to or arising out of: (1) use of the Services; (2) breach of these Legal Terms; (3) any breach of your representations and warranties set forth in these Legal Terms; (4) your violation of the rights of a third party, including but not limited to intellectual property rights; or (5) any overt harmful act toward any other user of the Services with whom you connected via the Services. Notwithstanding the foregoing, we reserve the right, at your expense, to assume the exclusive defense and control of any matter for which you are required to indemnify us, and you agree to cooperate, at your expense, with our defense of such claims. We will use reasonable efforts to notify you of any such claim, action, or proceeding which is subject to this indemnification upon becoming aware of it.</p>
<h2>USER DATA</h2>
<p>We will maintain certain data that you transmit to the Services for the purpose of managing the performance of the Services, as well as data relating to your use of the Services. Although we perform regular routine backups of data, you are solely responsible for all data that you transmit or that relates to any activity you have undertaken using the Services. You agree that we shall have no liability to you for any loss or corruption of any such data, and you hereby waive any right of action against us arising from any such loss or corruption of such data.</p>
<h2>ELECTRONIC COMMUNICATIONS, TRANSACTIONS,</h2>
<h3>AND SIGNATURES</h3>
<p>Visiting the Services, sending us emails, and completing online forms constitute electronic communications. You consent to receive electronic communications, and you agree that all agreements, notices, disclosures, and other communications we provide to you electronically, via email and on the Services, satisfy any legal requirement that such communication be in writing. YOU HEREBY AGREE TO THE

USE OF ELECTRONIC SIGNATURES, CONTRACTS, ORDERS, AND OTHER

RECORDS, AND TO ELECTRONIC DELIVERY OF NOTICES, POLICIES, AND

RECORDS OF TRANSACTIONS INITIATED OR COMPLETED BY US OR VIA THE

SERVICES. You hereby waive any rights or requirements under any statutes, regulations, rules, ordinances, or other laws in any jurisdiction which require an



original signature or delivery or retention of non-electronic records, or to payments or the granting of credits by any means other than electronic means.</p>
<h2>CALIFORNIA USERS AND RESIDENTS</h2>
<p>If any complaint with us is not satisfactorily resolved, you can contact the Complaint

Assistance Unit of the Division of Consumer Services of the California Department of

Consumer Affairs in writing at 1625 North Market Blvd., Suite N 112, Sacramento, California 95834 or by telephone at (800) 952-5210 or (916) 445-1254.</p>
<h2>MISCELLANEOUS</h2>
<p>These Legal Terms and any policies or operating rules posted by us on the Services or in respect to the Services constitute the entire agreement and understanding between you and us. Our failure to exercise or enforce any right or provision of these Legal Terms shall not operate as a waiver of such right or provision. These Legal Terms operate to the fullest extent permissible by law. We may assign any or all of our rights and obligations to others at any time. We shall not be responsible or liable for any loss, damage, delay, or failure to act caused by any cause beyond our reasonable control. If any provision or part of a provision of these Legal Terms is determined to be unlawful, void, or unenforceable, that provision or part of the provision is deemed severable from these Legal Terms and does not affect the validity and enforceability of any remaining provisions. There is no joint venture, partnership, employment or agency relationship created between you and us as a result of these Legal Terms or use of the Services. You agree that these Legal Terms will not be construed against us by virtue of having drafted them. You hereby waive any and all defenses you may have based on the electronic form of these Legal Terms and the lack of signing by the parties hereto to execute these Legal Terms.</p>
<h2>CONTACT US</h2>
<p>In order to resolve a complaint regarding the Services or to receive further information regarding use of the Services, please contact us at:</p>
<h3>ZeroIFTA</h3>
<h3>12 W. 2nd St #4324

Casper, WY 82601

United States</h3>
<h3>Phone: 1-800 594 7086</h3>
<h3>team@zeroifta.com</h3>
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
</body>
<script src="{{asset('assets/js/script.js')}}"></script>
</html>
