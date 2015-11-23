<?php

class ThemeHouse_NoForo_Listener_FileHealthCheck
{

    public static function fileHealthCheck(XenForo_ControllerAdmin_Abstract $controller, array &$hashes)
    {
        $hashes = array_merge($hashes,
            array(
                'library/ThemeHouse/NoForo/CacheRebuilder/DailyStats.php' => '73fe7f6b625319074d44cbcc40803b3b',
                'library/ThemeHouse/NoForo/CronEntry/CleanUp.php' => 'f10296b064baa54414f489295da5add9',
                'library/ThemeHouse/NoForo/CronEntry/Views.php' => 'c2131c91900bc741f0e732a2ece17660',
                'library/ThemeHouse/NoForo/Db.php' => 'ffbf085b58f26eae785ee789f169d8df',
                'library/ThemeHouse/NoForo/Extend/XenForo/ControllerAdmin/User.php' => '137abd2bcd3238c633f7785a2236c20b',
                'library/ThemeHouse/NoForo/Extend/XenForo/ControllerPublic/Index.php' => 'bdc229ae569333023e17ebafabdab8f0',
                'library/ThemeHouse/NoForo/Extend/XenForo/ControllerPublic/Member.php' => '082b0cb6ec918b15df714b8d006a5d22',
                'library/ThemeHouse/NoForo/Extend/XenForo/DataWriter/User.php' => 'cdd855a6c0e823c942ae7fd666450504',
                'library/ThemeHouse/NoForo/Extend/XenForo/Deferred/DailyStats.php' => '9bc0afcbbb27510c386a3587d2c71e19',
                'library/ThemeHouse/NoForo/Extend/XenForo/Model/Cron.php' => 'f352b9fc6f1412390e19989ff60f8ee1',
                'library/ThemeHouse/NoForo/Extend/XenForo/Model/ThreadRedirect.php' => '54daf403f696abcd916bb6d9d8c8fa6e',
                'library/ThemeHouse/NoForo/Extend/XenForo/Model/User.php' => 'fa5367e55942646d1a6297aadd8f849b',
                'library/ThemeHouse/NoForo/Extend/XenForo/Route/Prefix/Index.php' => 'd2d66ea6acc318a4e018b27690e36547',
                'library/ThemeHouse/NoForo/Listener/ContainerPublicParams.php' => '4c031c95c3e6c2d3eff980499e3338b3',
                'library/ThemeHouse/NoForo/Listener/InitDependencies.php' => '10c7a75fbc89022bbffe9a5308194206',
                'library/ThemeHouse/NoForo/Listener/LoadClass.php' => 'c725f6165b9494c6594ff926e59d2432',
                'library/ThemeHouse/NoForo/Listener/TemplatePostRender.php' => 'a56b811541314108bcbb799c030cc0a4',
                'library/ThemeHouse/NoForo/Model/NoForo.php' => '4c02acd9d0eb1d2634e1aa8b6e6a1f3a',
                'library/ThemeHouse/NoForo/Option/NoForum.php' => 'fb50385edec25b4d5bc1cd1bbe87aabd',
                'library/ThemeHouse/NoForo/Option/NoMessageCount.php' => 'fb4d20c19c8beb293d8822e490d47762',
                'library/ThemeHouse/NoForo/ViewPublic/Index.php' => 'f3d27f9038840d4e6a5ca3803e7ec65b',
                'library/ThemeHouse/Listener/ControllerPreDispatch.php' => 'fdebb2d5347398d3974a6f27eb11a3cd',
                'library/ThemeHouse/Listener/ControllerPreDispatch/20150911.php' => 'f2aadc0bd188ad127e363f417b4d23a9',
                'library/ThemeHouse/Listener/InitDependencies.php' => '8f59aaa8ffe56231c4aa47cf2c65f2b0',
                'library/ThemeHouse/Listener/InitDependencies/20150212.php' => 'f04c9dc8fa289895c06c1bcba5d27293',
                'library/ThemeHouse/Listener/ContainerParams.php' => '43bf59af9f140f58f665be373ac07320',
                'library/ThemeHouse/Listener/ContainerParams/20150106.php' => '36fa6f85128a9a9b2b88210c9abe33bd',
                'library/ThemeHouse/Listener/LoadClass.php' => '5cad77e1862641ddc2dd693b1aa68a50',
                'library/ThemeHouse/Listener/LoadClass/20150518.php' => 'f4d0d30ba5e5dc51cda07141c39939e3',
                'library/ThemeHouse/Listener/Template.php' => '0aa5e8aabb255d39cf01d671f9df0091',
                'library/ThemeHouse/Listener/Template/20150106.php' => '8d42b3b2d856af9e33b69a2ce1034442',
                'library/ThemeHouse/Listener/TemplatePostRender.php' => 'b6da98a55074e4cde833abf576bc7b5d',
                'library/ThemeHouse/Listener/TemplatePostRender/20150106.php' => 'efccbb2b2340656d1776af01c25d9382',
            ));
    }
}