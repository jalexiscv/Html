<?php


namespace App\Libraries;
/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

// Detect Web Browsers

class Browser
{
    private static $browserList = array(
        '114browser' => array('link' => 'https://ie.114la.com/', 'title' => '{%114Browser%}', 'code' => '114browser'),
        '115browser' => array('link' => 'https://ie.115.com/', 'title' => '{%115Browser%}', 'code' => '115browser'),
        '2345explorer' => array('link' => 'https://ie.2345.com/', 'title' => '{%2345Explorer%}', 'code' => '2345explorer'),
        '2345chrome' => array('link' => 'https://chrome.2345.com/', 'title' => '{%2345Chrome%}', 'code' => '2345chrome'),
        '360se' => array('link' => 'https://se.360.cn/', 'title' => '360 Explorer', 'code' => '360se'),
        '360ee' => array('link' => 'https://chrome.360.cn/', 'title' => '360 Chrome', 'code' => '360se'),
        '360 aphone browser' => array('link' => 'https://mse.360.cn/index.html', 'title' => '360 Aphone Browser', 'code' => '360se'),
        'abolimba' => array('link' => 'https://www.aborange.de/products/freeware/abolimba-multibrowser.php', 'title' => 'Abolimba', 'code' => 'abolimba'),
        'acoo browser' => array('link' => 'https://www.acoobrowser.com/', 'title' => 'Acoo {%Browser%}', 'code' => 'acoobrowser'),
        'alienforce' => array('link' => 'https://sourceforge.net/projects/alienforce/', 'title' => '{%Alienforce%}', 'code' => 'alienforce'),
        'amaya' => array('link' => 'http://www.w3.org/Amaya/', 'title' => '{%Amaya%}', 'code' => 'amaya'),
        'amiga-aweb' => array('link' => 'https://aweb.sunsite.dk/', 'title' => 'Amiga {%AWeb%}', 'code' => 'amiga-aweb'),
        'antfresco' => array('link' => 'https://www.espial.com/', 'title' => 'ANT {%Fresco%}', 'code' => 'antfresco'),
        'mrchrome' => array('link' => 'https://amigo.mail.ru/', 'title' => 'Amigo', 'code' => 'amigo'),
        'myibrow' => array('link' => 'https://myinternetbrowser.webove-stranky.org/', 'title' => '{%myibrow%}', 'code' => 'my-internet-browser'),
        'america online browser' => array('link' => 'https://downloads.channel.aol.com/browser', 'title' => 'America Online {%Browser%}', 'code' => 'aol'),
        'amigavoyager' => array('link' => 'https://v3.vapor.com/voyager/', 'title' => 'Amiga {%Voyager%}', 'code' => 'amigavoyager'),
        'aol' => array('link' => 'https://downloads.channel.aol.com/browser', 'title' => '{%AOL%}', 'code' => 'aol'),
        'arora' => array('link' => 'https://code.google.com/p/arora/', 'title' => '{%Arora%}', 'code' => 'arora'),
        'atomicbrowser' => array('link' => 'https://www.atomicwebbrowser.com/', 'title' => '{%AtomicBrowser%}', 'code' => 'atomicwebbrowser'),
        'barcapro' => array('link' => 'https://www.pocosystems.com/home/index.php?option=content&task=category&sectionid=2&id=9&Itemid=27', 'title' => '{%BarcaPro%}', 'code' => 'barca'),
        'barca' => array('link' => 'https://www.pocosystems.com/home/index.php?option=content&task=category&sectionid=2&id=9&Itemid=27', 'title' => '{%Barca%}', 'code' => 'barca'),
        'beamrise' => array('link' => 'https://www.beamrise.com/', 'title' => '{%Beamrise%}', 'code' => 'beamrise'),
        'beonex' => array('link' => 'https://www.beonex.com/', 'title' => '{%Beonex%}', 'code' => 'beonex'),
        // Baidu Browser Spark does not have own UA.
        'baidubrowser' => array('link' => 'https://browser.baidu.com/', 'title' => '{%baidubrowser%}', 'code' => 'bidubrowser'),
        'bidubrowser' => array('link' => 'https://browser.baidu.com/', 'title' => '{%bidubrowser%}', 'code' => 'bidubrowser'),
        'baiduhd' => array('link' => 'https://browser.baidu.com/', 'title' => '{%BaiduHD%}', 'code' => 'bidubrowser'),
        'baiduboxapp' => array('link' => 'https://mo.baidu.com/', 'title' => '{%BaiduBoxApp%}', 'code' => 'bidubrowser'),
        'blackbird' => array('link' => 'https://www.blackbirdbrowser.com/', 'title' => '{%Blackbird%}', 'code' => 'blackbird'),
        'blackhawk' => array('link' => 'https://www.netgate.sk/blackhawk/help/welcome-to-blackhawk-web-browser.html', 'title' => '{%BlackHawk%}', 'code' => 'blackhawk'),
        'blazer' => array('link' => 'https://en.wikipedia.org/wiki/Blazer_(web_browser)', 'title' => '{%Blazer%}', 'code' => 'blazer'),
        'bolt' => array('link' => 'https://www.boltbrowser.com/', 'title' => '{%Bolt%}', 'code' => 'bolt'),
        'bonecho' => array('link' => 'https://www.mozilla.org/projects/minefield/', 'title' => '{%BonEcho%}', 'code' => 'firefoxdevpre'),
        'browsex' => array('link' => 'https://pdqi.com/browsex/', 'title' => 'BrowseX', 'code' => 'browsex'),
        'browzar' => array('link' => 'https://www.browzar.com/', 'title' => '{%Browzar%}', 'code' => 'browzar'),
        'bunjalloo' => array('link' => 'https://code.google.com/p/quirkysoft/', 'title' => '{%Bunjalloo%}', 'code' => 'bunjalloo'),
        'camino' => array('link' => 'https://www.caminobrowser.org/', 'title' => '{%Camino%}', 'code' => 'camino'),
        'cayman browser' => array('link' => 'https://www.caymanbrowser.com/', 'title' => 'Cayman {%Browser%}', 'code' => 'caymanbrowser'),
        'charon' => array('link' => 'https://en.wikipedia.org/wiki/Charon_(web_browser)', 'title' => '{%Charon%}', 'code' => 'null'),
        'cheshire' => array('link' => 'https://downloads.channel.aol.com/browser', 'title' => '{%Cheshire%}', 'code' => 'aol'),
        'chimera' => array('link' => 'https://www.chimera.org/', 'title' => '{%Chimera%}', 'code' => 'null'),
        'chromeframe' => array('link' => 'https://code.google.com/chrome/chromeframe/', 'title' => '{%chromeframe%}', 'code' => 'chrome'),
        'chromeplus' => array('link' => 'https://www.chromeplus.org/', 'title' => '{%ChromePlus%}', 'code' => 'chromeplus'),
        'iron' => array('link' => 'https://www.srware.net/', 'title' => 'SRWare {%Iron%}', 'code' => 'srwareiron'),
        'chromium' => array('link' => 'https://www.chromium.org/', 'title' => '{%Chromium%}', 'code' => 'chromium'),
        'classilla' => array('link' => 'https://en.wikipedia.org/wiki/Classilla', 'title' => '{%Classilla%}', 'code' => 'classilla'),
        'coast' => array('link' => 'https://coastbyopera.com/', 'title' => '{%Coast%}', 'code' => 'coast'),
        'columbus' => array('link' => 'https://www.columbus-browser.com/', 'title' => '{%Columbus%}', 'code' => 'columbus'),
        'cometbird' => array('link' => 'https://www.cometbird.com/', 'title' => '{%CometBird%}', 'code' => 'cometbird'),
        'comodo_dragon' => array('link' => 'https://www.comodo.com/home/internet-security/browser.php', 'title' => 'Comodo {%Dragon%}', 'code' => 'comodo-dragon'),
        'conkeror' => array('link' => 'https://www.conkeror.org/', 'title' => '{%Conkeror%}', 'code' => 'conkeror'),
        'coolnovo' => array('link' => 'https://www.coolnovo.com/', 'title' => '{%CoolNovo%}', 'code' => 'coolnovo'),
        'corom' => array('link' => 'https://en.wikipedia.org/wiki/C%E1%BB%9D_R%C3%B4m%2B_(browser)', 'title' => '{%CoRom%}', 'code' => 'corom'),
        'crazy browser' => array('link' => 'https://www.crazybrowser.com/', 'title' => 'Crazy {%Browser%}', 'code' => 'crazybrowser'),
        'crmo' => array('link' => 'https://www.google.com/chrome', 'title' => '{%CrMo%}', 'code' => 'chrome'),
        'cruz' => array('link' => 'https://www.cruzapp.com/', 'title' => '{%Cruz%}', 'code' => 'cruz'),
        'cyberdog' => array('link' => 'https://www.cyberdog.org/about/cyberdog/cyberbrowse.html', 'title' => '{%Cyberdog%}', 'code' => 'cyberdog'),
        'dplus' => array('link' => 'https://dplus-browser.sourceforge.net/', 'title' => '{%DPlus%}', 'code' => 'dillo'),
        'deepnet explorer' => array('link' => 'https://www.deepnetexplorer.com/', 'title' => '{%Deepnet Explorer%}', 'code' => 'deepnetexplorer'),
        'demeter' => array('link' => 'https://www.hurrikenux.com/Demeter/', 'title' => '{%Demeter%}', 'code' => 'demeter'),
        'deskbrowse' => array('link' => 'https://www.deskbrowse.org/', 'title' => '{%DeskBrowse%}', 'code' => 'deskbrowse'),
        'dillo' => array('link' => 'https://www.dillo.org/', 'title' => '{%Dillo%}', 'code' => 'dillo'),
        'docomo' => array('link' => 'https://www.nttdocomo.com/', 'title' => '{%DoCoMo%}', 'code' => 'null'),
        'doczilla' => array('link' => 'https://www.doczilla.com/', 'title' => '{%DocZilla%}', 'code' => 'doczilla'),
        'dolfin' => array('link' => 'https://www.samsungmobile.com/', 'title' => '{%Dolfin%}', 'code' => 'samsung'),
        'dooble' => array('link' => 'https://dooble.sourceforge.net/', 'title' => '{%Dooble%}', 'code' => 'dooble'),
        'doris' => array('link' => 'https://www.anygraaf.fi/browser/indexe.htm', 'title' => '{%Doris%}', 'code' => 'doris'),
        'dorothy' => array('link' => 'https://www.dorothybrowser.com/', 'title' => '{%Dorothy%}', 'code' => 'dorothybrowser'),
        'edbrowse' => array('link' => 'https://edbrowse.sourceforge.net/', 'title' => '{%Edbrowse%}', 'code' => 'edbrowse'),
        'elinks' => array('link' => 'https://elinks.or.cz/', 'title' => '{%Elinks%}', 'code' => 'elinks'),
        'element browser' => array('link' => 'https://www.elementsoftware.co.uk/software/elementbrowser/', 'title' => 'Element {%Browser%}', 'code' => 'elementbrowser'),
        'enigma browser' => array('link' => 'https://en.wikipedia.org/wiki/Enigma_Browser', 'title' => 'Enigma {%Browser%}', 'code' => 'enigmabrowser'),
        'enigmafox' => array('link' => '#', 'title' => '{%EnigmaFox%}', 'code' => 'null'),
        'epic' => array('link' => 'https://www.epicbrowser.com/', 'title' => '{%Epic%}', 'code' => 'epicbrowser'),
        'epiphany' => array('link' => 'https://gnome.org/projects/epiphany/', 'title' => '{%Epiphany%}', 'code' => 'epiphany'),
        'escape' => array('link' => 'https://www.espial.com/products/tv-browser/', 'title' => '{%Escape%}', 'code' => 'espialtvbrowser'),
        'espial' => array('link' => 'https://www.espial.com/products/tv-browser/', 'title' => '{%Espial%}', 'code' => 'espialtvbrowser'),
        'fbav' => array('link' => 'https://www.facebook.com', 'title' => '{%FBAV%}', 'code' => 'facebook'),
        'fennec' => array('link' => 'https://wiki.mozilla.org/Fennec', 'title' => '{%Fennec%}', 'code' => 'fennec'),
        'firebird' => array('link' => 'https://seb.mozdev.org/firebird/', 'title' => '{%Firebird%}', 'code' => 'firebird'),
        'fireweb navigator' => array('link' => 'https://www.arsslensoft.tk/?q=node/7', 'title' => '{%Fireweb Navigator%}', 'code' => 'firewebnavigator'),
        'flock' => array('link' => 'https://www.flock.com/', 'title' => '{%Flock%}', 'code' => 'flock'),
        'fluid' => array('link' => 'https://www.fluidapp.com/', 'title' => '{%Fluid%}', 'code' => 'fluid'),
        'galeon' => array('link' => 'https://galeon.sourceforge.net/', 'title' => '{%Galeon%}', 'code' => 'galeon'),
        'globalmojo' => array('link' => 'https://www.globalmojo.com/', 'title' => '{%GlobalMojo%}', 'code' => 'globalmojo'),
        'gobrowser' => array('link' => 'https://www.gobrowser.cn/', 'title' => 'GO {%Browser%}', 'code' => 'gobrowser'),
        'google earth' => array('link' => 'https://earth.google.com/', 'title' => '{%Google Earth%}', 'code' => 'google'),
        'google.android.apps' => array('link' => 'https://www.google.com/', 'title' => 'Google App', 'code' => 'google'),
        'googleplus' => array('link' => 'https://plus.google.com/', 'title' => 'Google+', 'code' => 'google'),
        'youtube' => array('link' => 'https://www.youtube.com/', 'title' => '{%Youtube%}', 'code' => 'google'),
        'gosurf' => array('link' => 'https://gosurfbrowser.com/?ln=en', 'title' => '{%GoSurf%}', 'code' => 'gosurf'),
        'granparadiso' => array('link' => 'https://www.mozilla.org/', 'title' => '{%GranParadiso%}', 'code' => 'firefoxdevpre'),
        'greenbrowser' => array('link' => 'https://www.morequick.com/', 'title' => '{%GreenBrowser%}', 'code' => 'greenbrowser'),
        'gsa' => array('link' => 'https://www.google.com', 'title' => '{%GSA%}', 'code' => 'google'),
        'hana' => array('link' => 'https://www.alloutsoftware.com/', 'title' => '{%Hana%}', 'code' => 'hana'),
        'hotjava' => array('link' => 'http://java.sun.com/products/archive/hotjava/', 'title' => '{%HotJava%}', 'code' => 'hotjava'),
        'hv3' => array('link' => 'https://tkhtml.tcl.tk/hv3.html', 'title' => '{%Hv3%}', 'code' => 'hv3'),
        'hydra browser' => array('link' => 'https://www.hydrabrowser.com/', 'title' => 'Hydra Browser', 'code' => 'hydrabrowser'),
        'iris' => array('link' => 'https://www.torchmobile.com/', 'title' => '{%Iris%}', 'code' => 'iris'),
        'ibm webexplorer' => array('link' => 'https://www.networking.ibm.com/WebExplorer/', 'title' => 'IBM {%WebExplorer%}', 'code' => 'ibmwebexplorer'),
        'juzibrowser' => array('link' => 'https://www.123juzi.com/', 'title' => 'JuziBrowser', 'code' => 'juzibrowser'),
        'miuibrowser' => array('link' => 'https://www.xiaomi.com/', 'title' => '{%MiuiBrowser%}', 'code' => 'miuibrowser'),
        'microsoft office' => array('link' => 'https://www.microsoft.com', 'title' => 'Microsoft Office', 'code' => 'office'),
        'mxnitro' => array('link' => 'https://www.maxthon.com/nitro/', 'title' => '{%MxNitro%}', 'code' => 'mxnitro'),
        'ibrowse' => array('link' => 'https://www.ibrowse-dev.net/', 'title' => '{%IBrowse%}', 'code' => 'ibrowse'),
        'icab' => array('link' => 'https://www.icab.de/', 'title' => '{%iCab%}', 'code' => 'icab'),
        'icebrowser' => array('link' => 'https://www.icesoft.com/products/icebrowser.html', 'title' => '{%IceBrowser%}', 'code' => 'icebrowser'),
        'iceape' => array('link' => 'https://packages.debian.org/iceape', 'title' => '{%Iceape%}', 'code' => 'iceape'),
        'icecat' => array('link' => 'https://gnuzilla.gnu.org/', 'title' => 'GNU {%IceCat%}', 'code' => 'icecat'),
        'icedragon' => array('link' => 'https://www.comodo.com/home/browsers-toolbars/icedragon-browser.php', 'title' => '{%IceDragon%}', 'code' => 'icedragon'),
        'iceweasel' => array('link' => 'https://www.geticeweasel.org/', 'title' => '{%IceWeasel%}', 'code' => 'iceweasel'),
        'inet browser' => array('link' => 'https://alexanderjbeston.wordpress.com/', 'title' => 'iNet {%Browser%}', 'code' => 'null'),
        'itunes' => array('link' => 'https://www.apple.com', 'title' => '{%iTunes%}', 'code' => 'itunes'),
        'irider' => array('link' => 'https://en.wikipedia.org/wiki/IRider', 'title' => '{%iRider%}', 'code' => 'irider'),
        'internetsurfboard' => array('link' => 'https://inetsurfboard.sourceforge.net/', 'title' => '{%InternetSurfboard%}', 'code' => 'internetsurfboard'),
        'jasmine' => array('link' => 'https://www.samsungmobile.com/', 'title' => '{%Jasmine%}', 'code' => 'samsung'),
        'k-meleon' => array('link' => 'https://kmeleon.sourceforge.net/', 'title' => '{%K-Meleon%}', 'code' => 'kmeleon'),
        'k-ninja' => array('link' => 'https://k-ninja-samurai.en.softonic.com/', 'title' => '{%K-Ninja%}', 'code' => 'kninja'),
        'kapiko' => array('link' => 'https://ufoxlab.googlepages.com/cooperation', 'title' => '{%Kapiko%}', 'code' => 'kapiko'),
        'kazehakase' => array('link' => 'https://kazehakase.sourceforge.jp/', 'title' => '{%Kazehakase%}', 'code' => 'kazehakase'),
        'strata' => array('link' => 'https://www.kirix.com/', 'title' => 'Kirix {%Strata%}', 'code' => 'kirix-strata'),
        'kkman' => array('link' => 'https://www.kkman.com.tw/', 'title' => '{%KKman%}', 'code' => 'kkman'),
        'kinza' => array('link' => 'https://www.kinza.jp/', 'title' => '{%Kinza%}', 'code' => 'kinza'),
        'kmail' => array('link' => 'https://kontact.kde.org/kmail/', 'title' => '{%KMail%}', 'code' => 'kmail'),
        'kmlite' => array('link' => 'https://en.wikipedia.org/wiki/K-Meleon', 'title' => '{%KMLite%}', 'code' => 'kmeleon'),
        'konqueror' => array('link' => 'https://konqueror.kde.org/', 'title' => '{%Konqueror%}', 'code' => 'konqueror'),
        'kylo' => array('link' => 'https://kylo.tv/', 'title' => '{%Kylo%}', 'code' => 'kylo'),
        'lbrowser' => array('link' => 'https://wiki.freespire.org/index.php/Web_Browser', 'title' => '{%LBrowser%}', 'code' => 'lbrowser'),
        'links' => array('link' => 'https://links.twibright.com/', 'title' => '{%Links%}', 'code' => 'null'),
        'lbbrowser' => array('link' => 'https://www.liebao.cn/', 'title' => 'Liebao Browser', 'code' => 'lbbrowser'),
        'liebaofast' => array('link' => 'https://m.liebao.cn/', 'title' => '{%Liebaofast%}', 'code' => 'lbbrowser'),
        'leechcraft' => array('link' => 'https://leechcraft.org/', 'title' => 'LeechCraft', 'code' => 'null'),
        'lobo' => array('link' => 'https://www.lobobrowser.org/', 'title' => '{%Lobo%}', 'code' => 'lobo'),
        'lolifox' => array('link' => 'https://www.lolifox.com/', 'title' => '{%lolifox%}', 'code' => 'lolifox'),
        'lorentz' => array('link' => 'https://news.softpedia.com/news/Firefox-Codenamed-Lorentz-Drops-in-March-2010-130855.shtml', 'title' => '{%Lorentz%}', 'code' => 'firefoxdevpre'),
        'lunascape' => array('link' => 'https://www.lunascape.tv', 'title' => '{%Lunascape%}', 'code' => 'lunascape'),
        'lynx' => array('link' => 'https://lynx.browser.org/', 'title' => '{%Lynx%}', 'code' => 'lynx'),
        'madfox' => array('link' => 'https://en.wikipedia.org/wiki/Madfox', 'title' => '{%Madfox%}', 'code' => 'madfox'),
        'maemo browser' => array('link' => 'https://maemo.nokia.com/features/maemo-browser/', 'title' => '{%Maemo Browser%}', 'code' => 'maemo'),
        'maxthon' => array('link' => 'https://www.maxthon.com/', 'title' => '{%Maxthon%}', 'code' => 'maxthon'),
        ' mib/' => array('link' => 'https://www.motorola.com/content.jsp?globalObjectId=1827-4343', 'title' => '{%MIB%}', 'code' => 'mib'),
        'tablet browser' => array('link' => 'https://browser.garage.maemo.org/', 'title' => '{%Tablet browser%}', 'code' => 'microb'),
        'micromessenger' => array('link' => 'https://weixin.qq.com/', 'title' => '{%MicroMessenger%}', 'code' => 'wechat'),
        'midori' => array('link' => 'https://www.twotoasts.de/index.php?/pages/midori_summary.html', 'title' => '{%Midori%}', 'code' => 'midori'),
        'minefield' => array('link' => 'https://www.mozilla.org/projects/minefield/', 'title' => '{%Minefield%}', 'code' => 'minefield'),
        'minibrowser' => array('link' => 'https://dmkho.tripod.com/', 'title' => '{%MiniBrowser%}', 'code' => 'minibrowser'),
        'minimo' => array('link' => 'https://www-archive.mozilla.org/projects/minimo/', 'title' => '{%Minimo%}', 'code' => 'minimo'),
        'mosaic' => array('link' => 'https://en.wikipedia.org/wiki/Mosaic_(web_browser)', 'title' => '{%Mosaic%}', 'code' => 'mosaic'),
        'mozilladeveloperpreview' => array('link' => 'https://www.mozilla.org/projects/devpreview/releasenotes/', 'title' => '{%MozillaDeveloperPreview%}', 'code' => 'firefoxdevpre'),
        'mqqbrowser' => array('link' => 'https://browser.qq.com/', 'title' => '{%MQQBrowser%}', 'code' => 'qqbrowser'),
        'multi-browser' => array('link' => 'https://www.multibrowser.de/', 'title' => '{%Multi-Browser%}', 'code' => 'multi-browserxp'),
        'multizilla' => array('link' => 'https://multizilla.mozdev.org/', 'title' => '{%MultiZilla%}', 'code' => 'mozilla'),
        'myie2' => array('link' => 'https://www.myie2.com/', 'title' => '{%MyIE2%}', 'code' => 'myie2'),
        'namoroka' => array('link' => 'https://wiki.mozilla.org/Firefox/Namoroka', 'title' => '{%Namoroka%}', 'code' => 'firefoxdevpre'),
        'navigator' => array('link' => 'https://netscape.aol.com/', 'title' => 'Netscape {%Navigator%}', 'code' => 'netscape'),
        'netbox' => array('link' => 'https://www.netgem.com/', 'title' => '{%NetBox%}', 'code' => 'netbox'),
        'netcaptor' => array('link' => 'https://www.netcaptor.com/', 'title' => '{%NetCaptor%}', 'code' => 'netcaptor'),
        'netfront' => array('link' => 'https://www.access-company.com/', 'title' => '{%NetFront%}', 'code' => 'netfront'),
        'netnewswire' => array('link' => 'https://www.newsgator.com/individuals/netnewswire/', 'title' => '{%NetNewsWire%}', 'code' => 'netnewswire'),
        'netpositive' => array('link' => 'https://en.wikipedia.org/wiki/NetPositive', 'title' => '{%NetPositive%}', 'code' => 'netpositive'),
        'netscape' => array('link' => 'https://netscape.aol.com/', 'title' => '{%Netscape%}', 'code' => 'netscape'),
        'netsurf' => array('link' => 'https://www.netsurf-browser.org/', 'title' => '{%NetSurf%}', 'code' => 'netsurf'),
        'nf-browser' => array('link' => 'https://www.access-company.com/', 'title' => '{%NF-Browser%}', 'code' => 'netfront'),
        'nichrome/self' => array('link' => 'https://soft.rambler.ru/browser/', 'title' => '{%Nichrome/self%}', 'code' => 'nichromeself'),
        'nokiabrowser' => array('link' => 'https://browser.nokia.com/', 'title' => 'Nokia {%Browser%}', 'code' => 'nokia'),
        'novarra-vision' => array('link' => 'https://www.novarra.com/', 'title' => 'Novarra {%Vision%}', 'code' => 'novarra'),
        'obigo' => array('link' => 'https://en.wikipedia.org/wiki/Obigo_Browser', 'title' => '{%Obigo%}', 'code' => 'obigo'),
        'offbyone' => array('link' => 'https://www.offbyone.com/', 'title' => 'Off By One', 'code' => 'offbyone'),
        'omniweb' => array('link' => 'https://www.omnigroup.com/applications/omniweb/', 'title' => '{%OmniWeb%}', 'code' => 'omniweb'),
        'onebrowser' => array('link' => 'https://one-browser.com/', 'title' => '{%OneBrowser%}', 'code' => 'onebrowser'),
        'orca' => array('link' => 'https://www.orcabrowser.com/', 'title' => '{%Orca%}', 'code' => 'orca'),
        'oregano' => array('link' => 'https://en.wikipedia.org/wiki/Oregano_(web_browser)', 'title' => '{%Oregano%}', 'code' => 'oregano'),
        'origyn web browser' => array('link' => 'https://www.sand-labs.org/owb', 'title' => 'Oregano Web Browser', 'code' => 'owb'),
        'osb-browser' => array('link' => 'https://gtk-webcore.sourceforge.net/', 'title' => '{%osb-browser%}', 'code' => 'null'),
        'otter' => array('link' => 'https://otter-browser.org/', 'title' => '{%Otter%}', 'code' => 'otter'),
        ' pre/' => array('link' => 'https://www.palm.com/us/products/phones/pre/index.html', 'title' => 'Palm {%Pre%}', 'code' => 'palmpre'),
        'palemoon' => array('link' => 'https://www.palemoon.org/', 'title' => 'Pale {%Moon%}', 'code' => 'palemoon'),
        'patriott::browser' => array('link' => 'https://madgroup.x10.mx/patriott1.php', 'title' => 'Patriott {%Browser%}', 'code' => 'patriott'),
        'perk' => array('link' => 'https://www.perk.com/', 'title' => '{%Perk%}', 'code' => 'perk'),
        'phaseout' => array('link' => 'https://www.phaseout.net/', 'title' => 'Phaseout', 'code' => 'phaseout'),
        'phoenix' => array('link' => 'https://www.mozilla.org/projects/phoenix/phoenix-release-notes.html', 'title' => '{%Phoenix%}', 'code' => 'phoenix'),
        'playstation 4' => array('link' => 'https://us.playstation.com/', 'title' => 'PS4 Web Browser', 'code' => 'webkit'),
        'podkicker' => array('link' => 'https://www.podkicker.com/', 'title' => '{%Podkicker%}', 'code' => 'podkicker'),
        'podkicker pro' => array('link' => 'https://www.podkicker.com/', 'title' => '{%Podkicker Pro%}', 'code' => 'podkicker'),
        'pogo' => array('link' => 'https://en.wikipedia.org/wiki/AT%26T_Pogo', 'title' => '{%Pogo%}', 'code' => 'pogo'),
        'polaris' => array('link' => 'https://www.infraware.co.kr/eng/01_product/product02.asp', 'title' => '{%Polaris%}', 'code' => 'polaris'),
        'polarity' => array('link' => 'https://polarityweb.weebly.com/', 'title' => '{%Polarity%}', 'code' => 'polarity'),
        'prism' => array('link' => 'https://prism.mozillalabs.com/', 'title' => '{%Prism%}', 'code' => 'prism'),
        'puffin' => array('link' => 'https://www.puffinbrowser.com/index.php', 'title' => '{%Puffin%}', 'code' => 'puffin'),
        'qqbrowser' => array('link' => 'https://browser.qq.com/', 'title' => '{%QQBrowser%}', 'code' => 'qqbrowser'),
        'qq' => array('link' => 'https://im.qq.com/', 'title' => '{%QQ%}', 'code' => 'qq'),
        'qtweb internet browser' => array('link' => 'https://www.qtweb.net/', 'title' => 'QtWeb Internet {%Browser%}', 'code' => 'qtwebinternetbrowser'),
        'qtcarbrowser' => array('link' => 'https://www.teslamotors.com/', 'title' => '{%qtcarbrowser%}', 'code' => 'tesla'),
        'qupzilla' => array('link' => 'https://www.qupzilla.com/', 'title' => '{%QupZilla%}', 'code' => 'qupzilla'),
        'rekonq' => array('link' => 'https://rekonq.sourceforge.net/', 'title' => 'rekonq', 'code' => 'rekonq'),
        'retawq' => array('link' => 'https://retawq.sourceforge.net/', 'title' => '{%retawq%}', 'code' => 'terminal'),
        'rockmelt' => array('link' => 'https://www.rockmelt.com/', 'title' => '{%RockMelt%}', 'code' => 'rockmelt'),
        'ryouko' => array('link' => 'https://sourceforge.net/projects/ryouko/', 'title' => '{%Ryouko%}', 'code' => 'ryouko'),
        'saayaa' => array('link' => 'https://www.saayaa.com/', 'title' => 'SaaYaa Explorer', 'code' => 'saayaa'),
        'sailfishbrowser' => array('link' => 'https://github.com/sailfishos/sailfish-browser', 'title' => '{%SailfishBrowser%}', 'code' => 'sailfishbrowser'),
        'seamonkey' => array('link' => 'https://www.seamonkey-project.org/', 'title' => '{%SeaMonkey%}', 'code' => 'seamonkey'),
        'semc-browser' => array('link' => 'https://www.sonyericsson.com/', 'title' => '{%SEMC-Browser%}', 'code' => 'semcbrowser'),
        'semc-java' => array('link' => 'https://www.sonyericsson.com/', 'title' => '{%SEMC-java%}', 'code' => 'semcbrowser'),
        'shiira' => array('link' => 'https://www.shiira.jp/en.php', 'title' => '{%Shiira%}', 'code' => 'shiira'),
        'shiretoko' => array('link' => 'https://www.mozilla.org/', 'title' => '{%Shiretoko%}', 'code' => 'firefoxdevpre'),
        'sitekiosk' => array('link' => 'https://www.sitekiosk.com/SiteKiosk/Default.aspx', 'title' => '{%SiteKiosk%}', 'code' => 'sitekiosk'),
        'skipstone' => array('link' => 'https://www.muhri.net/skipstone/', 'title' => '{%SkipStone%}', 'code' => 'skipstone'),
        'skyfire' => array('link' => 'https://www.skyfire.com/', 'title' => '{%Skyfire%}', 'code' => 'skyfire'),
        'sleipnir' => array('link' => 'https://www.fenrir-inc.com/other/sleipnir/', 'title' => '{%Sleipnir%}', 'code' => 'sleipnir'),
        'silk' => array('link' => 'https://en.wikipedia.org/wiki/Amazon_Silk/', 'title' => 'Amazon {%Silk%}', 'code' => 'silk'),
        'slimboat' => array('link' => 'https://slimboat.com/', 'title' => '{%SlimBoat%}', 'code' => 'slimboat'),
        'slimbrowser' => array('link' => 'https://www.flashpeak.com/sbrowser/', 'title' => '{%SlimBrowser%}', 'code' => 'slimbrowser'),
        'superbird' => array('link' => 'https://superbird-browser.com', 'title' => '{%Superbird%}', 'code' => 'superbird'),
        'smarttv' => array('link' => 'https://www.freethetvchallenge.com/details/faq', 'title' => '{%SmartTV%}', 'code' => 'maplebrowser'),
        'songbird' => array('link' => 'https://www.getsongbird.com/', 'title' => '{%Songbird%}', 'code' => 'songbird'),
        'stainless' => array('link' => 'https://www.stainlessapp.com/', 'title' => '{%Stainless%}', 'code' => 'stainless'),
        'substream' => array('link' => 'https://itunes.apple.com/us/app/substream/id389906706?mt=8', 'title' => '{%SubStream%}', 'code' => 'substream'),
        'sulfur' => array('link' => 'https://www.flock.com/', 'title' => 'Flock {%Sulfur%}', 'code' => 'flock'),
        'sundance' => array('link' => 'https://digola.com/sundance.html', 'title' => '{%Sundance%}', 'code' => 'sundance'),
        'sunrise' => array('link' => 'https://www.sunrisebrowser.com/', 'title' => '{%Sunrise%}', 'code' => 'sunrise'),
        'surf' => array('link' => 'https://surf.suckless.org/', 'title' => '{%Surf%}', 'code' => 'surf'),
        'swiftfox' => array('link' => 'https://www.getswiftfox.com/', 'title' => '{%Swiftfox%}', 'code' => 'swiftfox'),
        'swiftweasel' => array('link' => 'https://swiftweasel.tuxfamily.org/', 'title' => '{%Swiftweasel%}', 'code' => 'swiftweasel'),
        'sylera' => array('link' => 'https://dombla.net/sylera/', 'title' => '{%Sylera%}', 'code' => 'null'),
        'taobrowser' => array('link' => 'https://browser.taobao.com/', 'title' => '{%TaoBrowser%}', 'code' => 'taobrowser'),
        'tear' => array('link' => 'https://wiki.maemo.org/Tear', 'title' => 'Tear', 'code' => 'tear'),
        'teashark' => array('link' => 'https://www.teashark.com/', 'title' => '{%TeaShark%}', 'code' => 'teashark'),
        'teleca' => array('link' => 'https://en.wikipedia.org/wiki/Obigo_Browser/', 'title' => '{%Teleca%}', 'code' => 'obigo'),
        'tencenttraveler' => array('link' => 'https://www.tencent.com/en-us/index.shtml', 'title' => 'Tencent {%Traveler%}', 'code' => 'tencenttraveler'),
        'tenfourfox' => array('link' => 'https://en.wikipedia.org/wiki/TenFourFox', 'title' => '{%TenFourFox%}', 'code' => 'tenfourfox'),
        'theworld' => array('link' => 'https://www.ioage.com/', 'title' => 'TheWorld Browser', 'code' => 'theworld'),
        'thunderbird' => array('link' => 'https://www.mozilla.com/thunderbird/', 'title' => '{%Thunderbird%}', 'code' => 'thunderbird'),
        'tizenbrowser' => array('link' => 'https://www.tizen.org/', 'title' => '{%Tizenbrowser%}', 'code' => 'tizen'),
        'tizen browser' => array('link' => 'https://www.tizen.org/', 'title' => '{%Tizen Browser%}', 'code' => 'tizen'),
        'tjusig' => array('link' => 'https://www.tjusig.cz/', 'title' => '{%Tjusig%}', 'code' => 'tjusig'),
        'ubrowser' => array('link' => 'https://www.uc.cn/', 'title' => '{%UBrowser%}', 'code' => 'ucbrowser'),
        'ucbrowser' => array('link' => 'https://www.uc.cn/', 'title' => '{%UCBrowser%}', 'code' => 'ucbrowser'),
        'uc browser' => array('link' => 'https://www.uc.cn/English/index.shtml', 'title' => '{%UC Browser%}', 'code' => 'ucbrowser'),
        'ucweb' => array('link' => 'https://www.ucweb.com/English/product.shtml', 'title' => '{%UCWEB%}', 'code' => 'ucbrowser'),
        'ultrabrowser' => array('link' => 'https://www.ultrabrowser.com/', 'title' => '{%UltraBrowser%}', 'code' => 'ultrabrowser'),
        'up.browser' => array('link' => 'https://www.openwave.com/', 'title' => '{%UP.Browser%}', 'code' => 'openwave'),
        'up.link' => array('link' => 'https://www.openwave.com/', 'title' => '{%UP.Link%}', 'code' => 'openwave'),
        'usejump' => array('link' => 'https://www.usejump.com/', 'title' => '{%Usejump%}', 'code' => 'usejump'),
        'uzardweb' => array('link' => 'https://en.wikipedia.org/wiki/UZard_Web', 'title' => '{%uZardWeb%}', 'code' => 'uzardweb'),
        'uzard' => array('link' => 'https://en.wikipedia.org/wiki/UZard_Web', 'title' => '{%uZard%}', 'code' => 'uzardweb'),
        'uzbl' => array('link' => 'https://www.uzbl.org/', 'title' => 'uzbl', 'code' => 'uzbl'),
        'vimprobable' => array('link' => 'https://www.vimprobable.org/', 'title' => '{%Vimprobable%}', 'code' => 'null'),
        'vivaldi' => array('link' => 'https://www.vivaldi.com', 'title' => '{%Vivaldi%}', 'code' => 'vivaldi'),
        'vonkeror' => array('link' => 'https://zzo38computer.cjb.net/vonkeror/', 'title' => '{%Vonkeror%}', 'code' => 'null'),
        'w3m' => array('link' => 'https://w3m.sourceforge.net/', 'title' => '{%W3M%}', 'code' => 'w3m'),
        'wget' => array('link' => 'https://www.gnu.org/software/wget/', 'title' => '{%wget%}', 'code' => 'null'),
        'curl' => array('link' => 'https://curl.haxx.se/', 'title' => '{%curl%}', 'code' => 'null'),
        'iemobile' => array('link' => 'https://www.microsoft.com/windowsmobile/en-us/downloads/microsoft/internet-explorer-mobile.mspx', 'title' => '{%IEMobile%}', 'code' => 'msie-mobile'),
        'waterfox' => array('link' => 'https://www.waterfoxproject.org/', 'title' => '{%WaterFox%}', 'code' => 'waterfox'),
        'webianshell' => array('link' => 'https://webian.org/shell/', 'title' => 'Webian {%Shell%}', 'code' => 'webianshell'),
        'webrender' => array('link' => 'https://webrender.99k.org/', 'title' => 'Webrender', 'code' => 'webrender'),
        'weltweitimnetzbrowser' => array('link' => 'https://weltweitimnetz.de/software/Browser.en.page', 'title' => 'Weltweitimnetz {%Browser%}', 'code' => 'weltweitimnetzbrowser'),
        'weibo' => array('link' => 'https://www.weibo.com', 'title' => '{%Weibo%}', 'code' => 'weibo'),
        'whatsapp' => array('link' => 'https://web.whatsapp.com/', 'title' => '{%WhatsApp%}', 'code' => 'whatsapp'),
        'whitehat aviator' => array('link' => 'https://www.whitehatsec.com/aviator/', 'title' => '{%WhiteHat Aviator%}', 'code' => 'aviator'),
        'wkiosk' => array('link' => 'https://www.app4mac.com/store/index.php?target=products&product_id=9', 'title' => 'wKiosk', 'code' => 'wkiosk'),
        'worldwideweb' => array('link' => 'http://www.w3.org/People/Berners-Lee/WorldWideWeb.html', 'title' => '{%WorldWideWeb%}', 'code' => 'worldwideweb'),
        'wyzo' => array('link' => 'https://www.wyzo.com/', 'title' => '{%Wyzo%}', 'code' => 'wyzo'),
        'x-smiles' => array('link' => 'https://www.xsmiles.org/', 'title' => '{%X-Smiles%}', 'code' => 'x-smiles'),
        'xiino' => array('link' => '#', 'title' => '{%Xiino%}', 'code' => 'null'),
        'yabrowser' => array('link' => 'https://browser.yandex.com/', 'title' => 'Yandex.{%Browser%}', 'code' => 'yandex'),
        'zbrowser' => array('link' => 'https://sites.google.com/site/zeromusparadoxe01/zbrowser', 'title' => '{%zBrowser%}', 'code' => 'zbrowser'),
        'zipzap' => array('link' => 'https://www.zipzaphome.com/', 'title' => '{%ZipZap%}', 'code' => 'zipzap'),
        'abrowse' => array('link' => 'https://abrowse.sourceforge.net/', 'title' => 'ABrowse {%Browser%}', 'code' => 'abrowse'),
        'firefox' => array('link' => 'https://www.mozilla.org/', 'title' => '{%Firefox%}', 'code' => 'firefox'),
        "chrome" => array('link' => 'https://www.google.com/chrome/', 'title' => '{%Chrome%}', 'code' => 'chrome'),
        'none' => array('link' => '#', 'title' => 'Unknown', 'name' => 'Unknown', 'version' => '', 'code' => 'unknown'));
    //


    private $useragent;
    private $browserDetails;


    public function __construct($useragent)
    {
        $browserDetails = array('version' => '', 'name' => '', 'title' => '');


        foreach (self::$browserList as $browser => $details) {
            $regExList = '/' . preg_quote($browser, '/') . '/i';
            if (preg_match($regExList, $useragent, $match)) {
                $browserDetails['name'] = $browser; // Asignar el nombre del brower del listado, no del match

                // Extraer la versión del navegador
                $version = '';
                $versionPatterns = array(
                    'Version\/([\d.]+)', // Captura "Version/x.y.z"
                    $browser . '[ \/]([\d.]+)' // Captura "BrowserName x.y.z" o "BrowserName/x.y.z"
                );

                foreach ($versionPatterns as $pattern) {
                    if (preg_match('/' . $pattern . '/i', $useragent, $match)) {
                        $version = $match[1];
                        break;
                    }
                }

                $browserDetails['version'] = $version;
                $browserDetails['title'] = $details['title'];

                break;
            }
        }

        $this->browserDetails = $browserDetails;
    }

    public function get_Name()
    {
        return ($this->browserDetails['name']);
    }

    public function get_Code()
    {
        return ("CODE");
    }


}