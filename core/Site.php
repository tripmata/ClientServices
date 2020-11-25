<?php


    class Site
    {
        public $PrimaryColor = "";
        public $SecondaryColor = "";
        public $TextColor = "";
        public $HeadingColor = "";
        public $SubheadingColor = "";
        public $TextFont = "";
        public $FontSize = "";
        public $Logo = "";
        public $Moto = "";
        public $SlideBrightness = 0.0;
        public $Tandc = "";
        public $Privacypolicy = "";
        public $Aboutus = "";
        public $BoldFont = "";
        public $LightFont = "";
        public $SecondaryFont = "";
        public $PageText = "";

        public $ShowLogo = true;
        public $ShowName = true;
        public $Customersaddress = true;
        public $Customerselfdatamgt = true;
        public $Guestformtype = "SIMPLE";  //options-> SIMPLE, INTERMEDIARY & DETAILED
        public $Payonline = true;
        public $Nopayreservation = false;


        public $Currency = "";
        public $Phone1 = "";
        public $Phone2 = "";
        public $Email1 = "";
        public $Email2 = "";


        private $sub = null;

        function __construct(Subscriber $subscriber=null)
        {
            $this->sub = DB::GetDB();

            $res = DB::Query("SELECT * FROM site");

            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();

                $this->PrimaryColor = $row['primary_color'];
                $this->SecondaryColor = $row['sec_color'];
                $this->TextColor = $row['text_color'];
                $this->HeadingColor = $row['heading_color'];
                $this->SubheadingColor = $row['subheading_color'];
                $this->TextFont = $row['text_font'];
                $this->FontSize = $row['font_size'];
                $this->Logo = $row['logo'];
                $this->Moto = $row['moto'];
                $this->SlideBrightness = $row['slide_brightness'];
                $this->Tandc = $row['tandc'];
                $this->Privacypolicy = $row['privcypolicy'];
                $this->Aboutus = $row['aboutus'];
                $this->BoldFont = $row['boldfont'];
                $this->LightFont = $row['lightfont'];
                $this->SecondaryFont = $row['secondaryfont'];
                $this->PageText = $row['pagetext'];

                $this->ShowLogo = Convert::ToBool($row['showlogo']);
                $this->ShowName = Convert::ToBool($row['showname']);
                $this->Customersaddress = Convert::ToBool($row['customersaddress']);
                $this->Customerselfdatamgt = Convert::ToBool($row['customersselfmgt']);
                $this->Guestformtype = $row['guestformtype'];
                $this->Nopayreservation = Convert::ToBool($row['nopayreservation']);

                $this->Payonline = Convert::ToBool($row['webpay']);

                $this->Currency = json_decode($row['currency']);

                $currency = Currency::ByCode("NGN");

                if($this->Currency == null)
                {
                    $this->Currency = Currency::ByCode("NGN");
                }

                $this->Email1 = $row['email1'];
                $this->Email2 = $row['email2'];
                $this->Phone1 = $row['phone1'];
                $this->Phone2 = $row['phone2'];
            }
            else
            {
              $this->Save();
            }
        }

        public function Save()
        {
            $res = DB::Query("SELECT subscriber FROM site");

            $primarycolor = $this->PrimaryColor;
            $secondarycolor = $this->SecondaryColor;
            $textcolor = $this->TextColor;
            $headingcolor = $this->HeadingColor;
            $subheadingcolor = $this->SubheadingColor;
            $textfont = $this->TextFont;
            $fontsize = $this->FontSize;
            $logo = $this->Logo;
            $moto = $this->Moto;
            $slidebrightness = $this->SlideBrightness;
            $tandc = addslashes($this->Tandc);
            $privacy = addslashes($this->Privacypolicy);
            $aboutus = addslashes($this->Aboutus);
            $boldfont = addslashes($this->BoldFont);
            $lightfont = addslashes($this->LightFont);
            $secondaryfont = addslashes($this->SecondaryFont);
            $pagetext = addslashes($this->PageText);

            $showname = Convert::ToInt($this->ShowName);
            $showlogo = Convert::ToInt($this->ShowLogo);
            $customersaddress = Convert::ToInt($this->Customersaddress);
            $customersselfmgt = Convert::ToInt($this->Customerselfdatamgt);
            $guestformtype = addslashes($this->Guestformtype);
            $payonline = Convert::ToInt($this->Payonline);
            $nopayreservation = Convert::ToInt($this->Nopayreservation);

            $currency =json_encode($this->Currency);
            $phone1 = addslashes($this->Phone1);
            $phone2 = addslashes($this->Phone2);
            $email1 = addslashes($this->Email1);
            $email2 = addslashes($this->Email2);

            if($res->num_rows > 0)
            {
                DB::Query("UPDATE site SET primary_color='$primarycolor',sec_color='$secondarycolor',text_color='$textcolor',
                heading_color='$headingcolor',subheading_color='$subheadingcolor',text_font='$textfont',font_size='$fontsize',
                logo='$logo',moto='$moto',slide_brightness='$slidebrightness',privcypolicy='$privacy',tandc='$tandc',aboutus='$aboutus',
                boldfont='$boldfont',lightfont='$lightfont',secondaryfont='$secondaryfont',pagetext='$pagetext',showlogo='$showlogo',
                showname='$showname',customersaddress='$customersaddress',customersselfmgt='$customersselfmgt',
                guestformtype='$guestformtype',webpay='$payonline',nopayreservation='$nopayreservation',
                 currency='$currency',email1='$email1',email2='$email2',phone1='$phone1',phone2='$phone2'");
            }
            else
            {
                DB::Query("INSERT INTO site (primary_color,sec_color,text_color,heading_color,subheading_color,text_font,font_size,logo,moto,slide_brightness,subscriber,privcypolicy,tandc,aboutus,boldfont,lightfont,secondaryfont,pagetext,showlogo,showname,customersaddress,customersselfmgt,guestformtype,webpay,nopayreservation,currency,phone1,phone2,email1,email2)
                VALUES('$primarycolor','$secondarycolor','$textcolor','$headingcolor','$subheadingcolor','$textfont','$fontsize','$logo','$moto','$slidebrightness','$id','$privacy','$tandc','$aboutus','$boldfont','$lightfont','$secondaryfont','$pagetext','$showlogo','$showname','$customersaddress','$customersselfmgt','$guestformtype','$payonline','$nopayreservation',
                '$currency','$phone1','$phone2','$email1','$email2')");
            }
        }
    }
