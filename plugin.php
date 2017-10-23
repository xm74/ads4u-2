<?php

class pluginAds4U extends Plugin {

        private $enable;

        private function ads4u()
        {
                $ret  = '<!-- Ads4U BEGIN -->'.PHP_EOL;
                $ret .= Sanitize::htmlDecode($this->getDbField('ads4uCode')).PHP_EOL;
                $ret .= '<!-- Ads4U END -->'.PHP_EOL;

                return $ret;
        }

        public function init()
        {
                $this->dbFields = array(
                        'enablePages'=>false,
                        'enablePosts'=>false,
                        'ads4uCode'=>''
                );
        }

        public function form()
        {
                global $Language;

                $html  = '<div>';
                $html .= '<label>'.$Language->get('enable-ads4u-on-pages').'</label>';
                $html .= '<select name="enablePages">';
                $html .= '<option value="true" '.($this->getValue('enablePages')===true?'selected':'').'>'.$Language->get('enabled').'</option>';
                $html .= '<option value="false" '.($this->getValue('enablePages')===false?'selected':'').'>'.$Language->get('disabled').'</option>';
                $html .= '</select>';
                $html .= '</div>';

                $html .= '<div>';
                $html .= '<label>'.$Language->get('enable-ads4u-on-posts').'</label>';
                $html .= '<select name="enablePosts">';
                $html .= '<option value="true" '.($this->getValue('enablePosts')===true?'selected':'').'>'.$Language->get('enabled').'</option>';
                $html .= '<option value="false" '.($this->getValue('enablePosts')===false?'selected':'').'>'.$Language->get('disabled').'</option>';
                $html .= '</select>';
                $html .= '</div>';

                $html .= '<div>';
                $html .= '<label>'.$Language->get('ads4u-html-code').'</label>';
                $html .= '<textarea id="jsads4uCode" type="text" name="ads4uCode">'.$this->getDbField('ads4uCode').'</textarea>';
                $html .= '<span class="tip">'.$Language->get('complete-this-field-with-html-code').'</span>';
                $html .= '</div>';

                return $html;
        }

        public function pageEnd()
        {
                global $Url, $Page;

                if( $this->getDbField('ads4uCode') != '' ) {
                        if( $Url->whereAmI()=='page' ) {
                                if( ($this->getDbField('enablePosts') && $Page->status()=='published') ||
                                    ($this->getDbField('enablePages') && $Page->status()=='static') ) {
                                        return $this->ads4u();
                                }
                        }
                }
                return false;
        }

}
