<?php

    class Article
    {
        public $Title = "";
        public $Body = "";
        public $Images = null;
        public $Image = "";

        private $mainTitle = "";
        private $mainBody = "";
        private $mainImages = null;
        private $mainImage = "";

        /**
         * @return string
         */
        public function getBody()
        {
            return $this->Body;
        }

        /**
         * @param string $Body
         */
        public function setBody($Body)
        {
            $this->Body = WixDecode($Body);
            $this->mainBody = $Body;
        }

        /**
         * @return string
         */
        public function getTitle()
        {
            return $this->Title;
        }

        /**
         * @param string $Title
         */
        public function setTitle($Title)
        {
            $this->Title = WixDecode($Title);
            $this->mainTitle = $Title;
        }

        /**
         * @return null
         */
        public function getImages()
        {
            return $this->Images;
        }

        /**
         * @param null $Images
         */
        public function setImages($Images)
        {
            $this->Images = $Images;
        }

        /**
         * @return string
         */
        public function getImage()
        {
            return $this->Image;
        }

        /**
         * @param string $Image
         */
        public function setImage($Image)
        {
            $this->Image = $Image;
        }

        public static function FormatTitle(Post $post, Articlesettings $settings=null)
        {
            $ret = "";
            $artSet = $settings;
            if($settings == null)
            {
                $artSet = new Articlesettings();
            }
            $ret = "<".$artSet->TitleSize." style='font-family: ".$artSet->TitleFont."; color: ".$artSet->TitleColor."; line-height: 150%;'>"
                .$post->Title."</".$artSet->TitleSize.">";
            return $ret;
        }

        public static function FormatPublishDate(WixDate $date, Articlesettings $settings=null)
        {
            $ret = "";
            $artSet = $settings;
            if($settings == null)
            {
                $artSet = new Articlesettings();
            }
            $ret = "<p style='font-family: ".$artSet->PublishDateFont."; color: ".$artSet->PublishDateColor.";
            font-size: ".$artSet->PublishDateSize.$artSet->PublicsDateSizeMetric.";'>"
                .$date->WeekDay.", ".$date->Day." / ".$date->MonthName." / ".$date->Year."</p>";
            return $ret;
        }

        public static function FormatAuthor($author, Articlesettings $settings=null)
        {
            $ret = "";
            $artSet = $settings;
            if($settings == null)
            {
                $artSet = new Articlesettings();
            }

            if($author != "")
            {
                $ret = "<p style='font-family: " . $artSet->AuthorFont . "; color: " . $artSet->AuthorColor . ";
             font-size: " . $artSet->AuthorFontSize . $artSet->AuthorFontSizeMetric . ";'>By "
                    . $author . "</p>";
            }
            return $ret;
        }

        public static function FormatArticleBody(Post $post, Articlesettings $settings=null)
        {
            $ret = "";
            $artSet = $settings;
            if($settings == null)
            {
                $artSet = new Articlesettings();
            }

            $html = str_get_html($post->Body);


            foreach($html->find("p") as $i)
            {
                $i->style = "font-family: ".$artSet->ArticleFont."; font-size: "
                    .$artSet->FontSize.$artSet->FontSizeMetric."; line-height: "
                    .$artSet->LineHeight.$artSet->LineHeightMetric."; color: "
                    .$artSet->ArticleColor.";";
            }
            $ret = $html->save();
            return $ret;
        }


        public static function Shorten($text, $length=12)
        {
            $r = explode(" ", strip_tags($text));

            $ret = "";
            $i = 0;

            for(; $i < $length; $i++)
            {
                if($ret == "")
                {
                    $ret = $r[$i];
                }
                else
                {
                    $ret .= " ".$r[$i];
                }
                if(($i + 1) == count($r)){break;}
            }

            if($i == 12)
            {
                $ret .="...";
            }

            return $ret;
        }
    }