<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Reset {{$type}}</title>
  <style type="text/css">

    .footer-icons{
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    html {
      font-size: 100%;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%
    }

    * {
      font-family: sans-serif
    }

    html, body{
        height: 100%;
    }

    body {
    display: flex;
    flex-direction: column;
    justify-content: center;
      margin: 0
    }

    a:focus {
      outline: thin dotted
    }

    a{
        color: inherit !important;
        text-decoration: none !important;
    }

    img {
      border: 0;
      -ms-interpolation-mode: bicubic
    }

    table {
      border-collapse: collapse;
      border-spacing: 0;
    }

    /* hotmail / outlook.com */
    table,
    td {
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }



    /* IExplorer */
    body,
    table,
    td,
    p,
    a,
    li,
    blockquote {
      -ms-text-size-adjust: 100%;
      -webkit-text-size-adjust: 100%;
      font-weight: normal !important;
    }

    h2 {
      display: block;
      font-size: 20px;
      font-style: normal;
      font-weight: normal;
      line-height: 28px;
      color: #111827;
      font-weight: 600
    }

    h3 {
      display: block;
      font-size: 14px;
      font-style: normal;
      font-weight: normal;
      line-height: 28px;
      color: #374151;
      font-weight: 400
    }

    h4 {
      display: block;
      font-size: 14px;
      font-weight: normal;
      line-height: 20px;
      color: #374151;
    }

    h5{
        color: #6B7280;
        line-height: 16px !important;
        font-size: 12px;
        font-weight: normal;
        margin: 0px;
        text-align: center;
        margin-bottom: 20px
    }

    table[class=flexibleContainerCellDivider] {
      padding-bottom: 0 !important;
      padding-top: 0 !important;
    }

    body,
    #bodyTbl {
      background-color: #F9FAFB;
    }

    #emailHeader {
      background-color: #F9FAFB;
    }

    #emailBody {
      background-color: #FFFFFF;
      border-radius: 8px;
      filter: drop-shadow(0px 1px 4px #00000035)
    }

    #emailFooter {
      background-color: #F9FAFB;
    }

    .textContent {
      color: #8B8B8B;
      font-family: Helvetica;
      font-size: 16px;
      line-height: 125%;
      text-align: center;
    }

    .textContent a {
      text-decoration: none !important;
    }

    .emailButton {
      background-color: #205478;
      border-collapse: separate;
    }

    .buttonContent {
      color: #FFFFFF;
      font-family: Helvetica;
      font-size: 18px;
      font-weight: bold;
      line-height: 100%;
      padding: 15px;
      text-align: center;
    }

    .buttonContent a {
      color: #FFFFFF;
      display: block;
      text-decoration: none !important;
      border: 0 !important;
    }

    #invisibleIntroduction {
      display: none;
      display: none !important;
    }

    /* hide the introduction text */
    /* other framework hacks and overrides */
    span[class=ios-color-hack] a {
      color: #275100 !important;
      text-decoration: none !important;
    }

    /* Remove all link colors in IOS (below are duplicates based on the color preference) */
    span[class=ios-color-hack2] a {
      color: #205478 !important;
      text-decoration: none !important;
    }

    span[class=ios-color-hack3] a {
      color: #8B8B8B !important;
      text-decoration: none !important;
    }

    /* phones and sms */
    .a[href^="tel"],
    a[href^="sms"] {
      text-decoration: none !important;
      color: #606060 !important;
      pointer-events: none !important;
      cursor: default !important;
    }


    /* responsive styles */
    @media only screen and (max-width: 480px) {
      body {
        width: 100% !important;
        min-width: 100% !important;
      }

      table[id="emailHeader"],
      table[id="emailBody"],
      table[id="emailFooter"],
      table[class="flexibleContainer"] {
        width: 100% !important;
      }

      td[class="flexibleContainerBox"],
      td[class="flexibleContainerBox"] table {
        display: block;
        width: 100%;
        text-align: left;
      }

      td[class="imageContent"] img {
        height: auto !important;
        width: 100% !important;
        max-width: 100% !important;
      }

      img[class="flexibleImage"] {
        height: auto !important;
        width: 100% !important;
        max-width: 100% !important;
      }

      img[class="flexibleImageSmall"] {
        height: auto !important;
        width: auto !important;
      }

      table[class="flexibleContainerBoxNext"] {
        padding-top: 10px !important;
      }

      table[class="emailButton"] {
        width: 100% !important;
      }

      td[class="buttonContent"] {
        padding: 0 !important;
      }

      td[class="buttonContent"] a {
        padding: 15px !important;
      }
    }

    .logo{
       display: grid;
       place-content: center;
       width:100%
    }

    .logo img{
        width: 145.9px
    }


    button {
        background-color: #0D9488;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        color: #ffffff;
        display: flex;
        align-items: center !important;
        gap: 8px;
        cursor: pointer;
    }

    .button > a{
        color: inherit;
        text-decoration: none !important;
    }

    .b-t{
      line-height: 20px;
      font-size: 14px;
      font-weight: 500;
      color: #FFFFFF;
    }


  </style>

</head>

<body bgcolor="#F9FAFB" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
  <center style="background-color:#F9FAFB;">
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTbl" style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important; border-radius: 8px">
      <tr>
        <td align="center" valign="top" id="bodyCell">

          <table bgcolor="#F9FAFB" border="0" cellpadding="0" cellspacing="0" width="500" id="emailHeader">
            <tr>
              <td align="center" valign="top">

                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td align="center" valign="top">

                      <table border="0" cellpadding="10" cellspacing="0" width="500" class="flexibleContainer">
                        <tr>
                          <td valign="top" width="500" class="flexibleContainerCell">

                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td align="left" valign="middle" id="invisibleIntroduction" class="flexibleContainerBox" style="display:none;display:none !important;">
                                  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:100%;">
                                    <tr>
                                      <td align="left" class="textContent">
                                        <div style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#828282;text-align:center;line-height:120%;">
                                        </div>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>

                    </td>
                  </tr>
                </table>

              </td>
            </tr>
          </table>

          <table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="500" id="emailBody">

            <tr>
              <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF; border-radius: 8px 8px 0px 0px;  " bgcolor="#1F2937">
                  <tr>
                    <td align="center" valign="top">
                
                      <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                        <tr>
                          <td align="center" valign="top" width="500" class="flexibleContainerCell">
                            <center>
                            <table border="0" cellpadding="32" cellspacing="0" width="100%">
                              <tr>
                                <td align="center" valign="top" class="textContent">
                                    <img width="145.9" src="{{env('APP_URL')}}/images/logo.png"  alt="">
                                </td>
                              </tr>
                            </table>
                          </center>
                          </td>
                        </tr>
                      </table>
                   
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td align="center" valign="top">
                      <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                        <tr>
                          <td align="center" valign="top" width="500" class="flexibleContainerCell">
                            <table border="0" cellpadding="30" cellspacing="0" width="100%">
                              <tr>
                                <td align="center" valign="top">

                                  <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                      <td valign="top" class="textContent">
                                        <h2 >Hello {{$name}},</h2>

                                        <h3>
                                        @if ($type == 'email')
                                            Click on the below create new email button to create your email for Build24
                                        @endif

                                        @if ($type == 'password')
                                            Click on the below create password button to create your password for Build24
                                        @endif
                                      </h3>

                                        <table class="button" align="center">
                                          <tr>
                                            <td>
                                             <a href="{{$url}}" >
                                              <button align="center">
                                                <img width="20" style="padding-right: 8px" src="{{env('APP_URL')}}/images/locked.png"  alt="">
                                                @if ($type == 'password')
                                                  <span class="b-t"> Create password</span>                                                    
                                                @endif
                                                @if ($type == 'email')
                                                  <span class="b-t"> Create new email</span>                                                    
                                                @endif
                                              </button>
                                             </a>

                                        </td>
                                      </tr>
                                    </table>
                                        <h4>Regards,</h4>
                                        <h4>Team Build24 Learning center</h4>
                                      </td>
                                    </tr>
                                  </table>

                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

    
          </table>

          <!-- footer -->
          <table bgcolor="#F9FAFB" border="0" cellpadding="0" cellspacing="0" width="500" id="emailFooter">
            <tr>
              <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td align="center" valign="top">
                      <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                        <tr>
                          <td align="center" valign="top" width="500" class="flexibleContainerCell">
                            <table border="0" cellpadding="24" cellspacing="0" width="100%">
                              <tr>
                                <td valign="top" bgcolor="#F9FAFB">
                                  <h5>
                                        This message was sent automatically using uild24 learning center, service offered by XYZ company, Str. Pacurari nr. 24, New York 700511, United states. If you think this reached you by mistake, please email us at <a class="" href="mailto:contact@build24learningcenter.com">
                                            contact@build24learningcenter.com
                                        </a>
                            
                                  </h5>
                                 
                                    <table border="0" cellpadding="32" cellspacing="0" width="100%">
                                      <tr>
                                        <td align="center" valign="top" class="textContent">
                                            <img width="20" style="padding-right: 8px" src="{{env('APP_URL')}}/images/instagram.png"  alt="">
                                            <img width="20" style="padding-right: 8px" src="{{env('APP_URL')}}/images/facebook.png"  alt="">
                                            <img width="20" src="{{env('APP_URL')}}/images/world.png"  alt="">
                                        </td>
                                      </tr>
                                    </table>
                                 
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!-- // end of footer -->

        </td>
      </tr>
    </table>
  </center>
</body>

</html>