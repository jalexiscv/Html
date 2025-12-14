<?php

namespace App\Libraries;

use App\Libraries\Html\HtmlTag;

class Icons
{
    public static function get_Attachment()
    {
        return (self::get_Icon(" icon-paperclip"));
    }

    public static function get_Icon($icon)
    {
        $i = HtmlTag::tag('i');
        $i->attr('class', "icon {$icon}");
        return ($i->render());

    }

    public static function get_Content()
    {
        return (self::get_Icon("far fa-book-open"));
    }

    public static function get_Authorship()
    {
        return (self::get_Icon("icon-user"));
    }

    public static function get_Location()
    {
        return (self::get_Icon("icon-map-pin"));
    }

    public static function get_Multimedia()
    {
        return (self::get_Icon("icon-film"));
    }

    public static function get_Calendar()
    {
        return (self::get_Icon("icon-calendar"));
    }

    public static function get_Bets()
    {
        return (self::get_Icon("icon-coins-1"));
    }

    public static function get_Conversations()
    {
        return (self::get_Icon("icon-whatsapp"));
    }

    public static function get_Directory()
    {
        return (self::get_Icon("icon-directory"));
    }

    public static function get_Events()
    {
        return (self::get_Icon("icon-events"));
    }

    public static function get_Home()
    {
        return (self::get_Icon("icon-home-2"));
    }

    public static function get_Page()
    {
        return (self::get_Icon("icon-triangle"));
    }

    public static function get_Password()
    {
        return (self::get_Icon("fas fa-lock-alt"));
    }

    public static function get_Potabilization()
    {
        return (self::get_Icon("icon-chemistry-1"));
    }

    public static function getSearch()
    {
        return (self::get_Icon("icon-search"));
    }

    public static function get_Security()
    {
        return (self::get_Icon("icon-security"));
    }

    public static function get_Session()
    {
        return (self::get_Icon("icon-users"));
    }

    public static function get_Social()
    {
        return (self::get_Icon("icon-socialnetwork"));
    }

    public static function get_Ticket()
    {
        return (self::get_Icon("icon-ticket"));
    }

    public static function get_Time()
    {
        return (self::get_Icon("icon-clock"));
    }

    public static function get_Top()
    {
        return (self::get_Icon("icon-pointing-finger"));
    }

    public static function get_News()
    {
        return (self::get_Icon("icon-twitter"));
    }

    public static function get_New()
    {
        return (self::get_Icon("icon-049-add"));
    }

    public static function get_Classifieds()
    {
        return (self::get_Icon("icon-dribbble"));
    }

    public static function get_Bookmarks()
    {
        return (self::get_Icon("icon-bookmark"));
    }

    public static function get_Images()
    {
        return (self::get_Icon("icon-instagram"));
    }

    public static function get_Like()
    {
        return (self::get_Icon("icon-like"));
    }

    public static function get_DisLike()
    {
        return (self::get_Icon("icon-dislike"));
    }

    public static function get_View()
    {
        return (self::get_Icon("far fa-eye"));
    }

    public static function get__Map()
    {
        return (self::get_Icon("icon-map-pin"));
    }

    public static function get_MenuItem()
    {
        return (self::get_Icon("icon-next"));
    }

    public static function get_User()
    {
        return (self::get_Icon("far fa-user"));
    }

    public static function get_Users()
    {
        return (self::get_Icon("icon-users"));
    }

    public static function get_Roles()
    {
        return (self::get_Icon("far fa-crown"));
    }

    public static function get_Bank()
    {
        return (self::get_Icon("far fa-university"));
    }

    public static function get_Permissions()
    {
        return (self::get_Icon("icon-permissions"));
    }

    public static function get_Double()
    {
        return (self::get_Icon("icon-numbers"));
    }

    public static function get_Settings()
    {
        return (self::get_Icon("icon-settings"));
    }

    public static function get_Delete()
    {
        return (self::get_Icon("far fa-trash-alt"));
    }

    public static function get_Edit()
    {
        return (self::get_Icon("far fa-edit"));
    }

    public static function get_Clone()
    {
        return (self::get_Icon("icon-github"));
    }

    public static function get_Email()
    {
        return (self::get_Icon("fal fa-envelope"));
    }

    public static function get_Nexus()
    {
        return (self::get_Icon("icon-internet"));
    }

    public static function get_Development()
    {
        return (self::get_Icon("icon-paper-plane-1"));
    }

    public static function get_Phone()
    {
        return (self::get_Icon("far fa-phone-alt"));
    }

    public static function get_Notify()
    {
        return (self::get_Icon("icon-notify"));
    }

    public static function get_Number()
    {
        return (self::get_Icon("fas fa-hashtag"));
    }

    public static function get_Money()
    {
        return (self::get_Icon("fas fa-dollar-sign"));
    }

    public static function get_Messages()
    {
        return (self::get_Icon("icon-messages"));
    }

    public static function get_Options()
    {
        return (self::get_Icon("icon-more-vertical"));
    }

    public static function get_Success()
    {
        return (self::get_Icon("icon-success"));
    }

    public static function get_Statistics()
    {
        return (self::get_Icon("icon-statistics"));
    }

    public static function get_List()
    {
        return (self::get_Icon("icon-list"));
    }

    public static function get_Add()
    {
        return (self::get_Icon("icon-add"));
    }

    public static function get_Keypad()
    {
        return (self::get_Icon("icon-keypad"));
    }

    public static function get_Navicon()
    {
        return (self::get_Icon("icon-menu"));
    }

    public static function get_Bars()
    {
        return (self::get_Icon("icon-briefcase"));
    }

    public static function get_Next()
    {
        return (self::get_Icon("icon-next"));
    }

    public static function get_Internet()
    {
        return (self::get_Icon("icon-internet"));
    }

    public static function get_Info()
    {
        return (self::get_Icon("icon-info"));
    }

    public static function get_Directories()
    {
        return (self::get_Icon("icon-directories"));
    }

    public static function get_Live()
    {
        return (self::get_Icon("icon-live"));
    }

    public static function get_Lock()
    {
        return (self::get_Icon("fad fa-lock-alt"));
    }

    public static function get_Unlock()
    {
        return (self::get_Icon("icon-unlock"));
    }

    public static function get_Products()
    {
        return (self::get_Icon("fas fa-list"));
    }

    public static function get_Creator()
    {
        return (self::get_Icon("icon-network"));
    }

    public static function get_WhatsApp()
    {
        return (self::get_Icon("icon-whatsapp"));
    }

    public static function get_Currency()
    {
        return (self::get_Icon("icon-currency"));
    }

    public static function get_Expiration()
    {
        return (self::get_Icon("icon-expiration"));
    }

    public static function get_Grid()
    {
        return (self::get_Icon("far fa-border-all"));
    }

    public static function get_Component()
    {
        return (self::get_Icon("far fa-cog"));
    }

}

?>