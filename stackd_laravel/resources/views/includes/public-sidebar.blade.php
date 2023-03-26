<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="min-height:calc( 22vw + 860px );height:auto;box-shadow: 0px 6px 58px rgb(196 203 214 / 10%); z-index: 100;border-radius:1.5rem;">
    <!-- Sidebar - Brand -->
    <li>
        <a class="sidebar-brand d-flex align-items-center" href="<?= url('/home') ?>">
            <div class="sidebar-brand-icon">
                <img class="lw-logo-img" src="<?= getStoreSettings('small_logo_image_url') ?>" alt="<?= getStoreSettings('name') ?>">
            </div>
            <img class="lw-logo-img d-sm-none d-none d-md-block" src="<?= getStoreSettings('logo_image_url') ?>" alt="<?= getStoreSettings('name') ?>">
            <img class="lw-logo-img d-sm-block d-md-none" src="<?= getStoreSettings('small_logo_image_url') ?>" alt="<?= getStoreSettings('name') ?>">
        </a>
    </li>
    <li class="mt-2 d-none d-md-block">
        <!-- profile related -->
        <div class="card">
            <div >
                <img class="lw-profile-thumbnail lw-lazy-img" data-src="<?= getUserAuthInfo('profile.profile_picture_url') ?>">
                <p data-model="userData.kanji_name" style="
                    font-family: Nunito Sans;
                    font-style: normal;
                    font-weight: bold;
                    font-size: 16px;
                    line-height: 24px;
                    text-align: center;
                    color: #FFFFFF; padding-top:0.5rem;">
                        <?= getUserAuthInfo('profile.kanji_name') ?>
                </p>
            </div>
        </div>

        <div class="card d-none">
            <div class="" style="">
                <p  style="font-family: Nunito Sans;
                            font-style: normal;
                            font-weight: bold;
                            font-size: 11px;
                            line-height: 15px;
                            color: #FFFFFF;">
                    <span style="padding:0.25rem 0.5rem;background: #FF3F3F;border-radius: 7px;">
                     <i class="fa fa-eye"></i>&nbsp;Icognito</span>
                </p>
            </div>
        </div>
        @if(!isAdmin())
        <div class="card">
            <div class="" style="">
                <p  style="font-family: Nunito Sans;
                            font-style: normal;
                            font-weight: bold;
                            font-size: 15px;
                            line-height: 24px;
                            color: #FFFFFF;">
                @if(!getUserMembership())            
                    <a href="<?= route('user.read.setting', ['pageType' => 'billing']) ?>" class="pro_btn">        
                        <span style="padding:0.25rem 0.75rem;background: #FF3F3F;border-radius: 7px;">
                            JOIN PRO
                        </span>
                    </a> 
                @else
                    <a href="<?= route('user.read.setting', ['pageType' => 'billing']) ?>" class="pro_btn">        
                        <span style="padding: 0.25rem 0.75rem;background: #191919;border-radius: 7px;border: 2px solid #ff3f3f; color: #ff3f3f;">
                            <?php 
                            //echo Str::ucfirst(getUserMembership()); 
                            $membershipName = getUserMembership();
                            if( $membershipName == "pro" ){
                                echo "Pro";
                            } else if($membershipName == "standard"){
                                echo "PT Basic";
                            } else if($membershipName == "premium") {
                                echo "PT Pro";
                            }
                            
                            ?>
                        </span>
                    </a> 
                @endif

                </p>
            </div>
        </div>
        @endif
    </li>

    @if(0)
        <li class="nav-item mt-2 d-sm-block d-md-none">
            <a href class="nav-link" onclick="getChatMessenger('<?= route('user.read.all_conversation') ?>', true)" id="lwAllMessageChatButton" data-chat-loaded="false" data-toggle="modal" data-target="#messengerDialog">
                <i class="far fa-comments"></i>
                <span><?= __tr('Messenger') ?></span>
            </a>
        </li>
        <!-- Notification Link -->
        <li class="nav-item dropdown no-arrow mx-1 d-sm-block d-md-none">
            <a class="nav-link dropdown-toggle lw-ajax-link-action" href="<?= route('user.notification.write.read_all_notification') ?>" data-callback="onReadAllNotificationCallback" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-method="post">
                <i class="fas fa-bell fa-fw"></i>
                <span><?= __tr('Notification') ?></span>
                <span class="badge badge-danger badge-counter" id="lwNotificationCount"><?= getNotificationList()['notificationCount'] ?></span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    <?= __tr('Notification') ?>
                </h6>
                <!-- Notification block -->
                @if(!__isEmpty(getNotificationList()['notificationData']))
                <span id="lwNotificationList">
                    @foreach(getNotificationList()['notificationData'] as $notification)

                    <!-- show all notification list -->
                    <a class="dropdown-item d-flex align-items-center" href="<?= $notification['actionUrl'] ?>">
                        <div>
                            <div class="small text-gray-500"><?= $notification['created_at'] ?></div>
                            <span class="font-weight-bold"><?= $notification['message'] ?></span>
                        </div>
                    </a>
                    <!-- show all notification list -->
                    @endforeach
                </span>
                <!-- show all notification link -->
                <a class="dropdown-item text-center small text-gray-500" href="<?= route('user.notification.read.view') ?>" id="lwShowAllNotifyLink"><?= __tr('Show All Notifications.') ?></a>
                <!-- /show all notification link -->
                @else
                <!-- info message -->
                <a class="dropdown-item text-center small text-gray-500"><?= __tr('There are no notification.') ?></a>
                <!-- /info message -->
                @endif
                <!-- /Notification block -->
            </div>
        </li>
        <!-- /Notification Link -->

        <!-- Nav Item - Messages -->
        <li class="nav-item d-sm-block d-md-none">
            <a class="nav-link" href="<?= route('user.credit_wallet.read.view') ?>">
                <i class="fas fa-coins fa-fw mr-2"></i>
                <span><?= __tr('Credit Wallet') ?></span>
                <span class="badge badge-success badge-counter"><?= totalUserCredits() ?></span>
            </a>
        </li>

        <!-- Nav Item - Messages -->
        <li class="nav-item d-sm-block d-md-none">
            <a class="nav-link" href data-toggle="modal" data-target="#boosterModal">
                <i class="fas fa-bolt fa-fw mr-2"></i>
                <span><?= __tr('Profile Booster') ?></span>
                <span id="lwBoosterTimerCountDownOnSB"></span>
            </a>
        </li>
    @endif

    @if(isset($is_profile_page) and ($is_profile_page === true))
    @if(!$isBlockUser and !$blockByMeUser)
    @stack('sidebarProfilePage')
    @endif
    @endif

    <hr class="sidebar-divider mt-2 mb-2 d-sm-block d-md-none">
    <!-- Heading -->

    @if(isAdmin())
    <li class="mt-2 nav-item <?= makeLinkActive('manage.dashboard') ?>">
        <a class="nav-link" target="_blank" href="<?= route('manage.dashboard') ?>">
            <i class="fas fa-cogs" style="color:white;font-size:18px;"></i>
            <span class="pl-2"><?= __tr('Admin Panel') ?></span>
        </a>
    </li>
    @endif
    
    <li class="mt-2 align-items-center nav-item <?= makeLinkActive('user.read.find_matches') ?>">
        <a class="nav-link" href="<?= route('user.read.find_matches') ?>">
            <i class="fas fa-search" style="color:white;font-size:18px;"></i>
            <span class="pl-2"><?= __tr('Discover') ?></span>
        </a>
    </li>
    <li class="mt-2 nav-item <?= makeLinkActive('user.profile_view') ?>">
        <a class="nav-link" href="<?= route('user.profile_view', ['username' => getUserAuthInfo('profile.username')]) ?>">
            <i class="fas fa-user" style="color:white;font-size:18px;"></i>
            <span class="pl-2"><?= __tr('Profile') ?></span>
        </a>
    </li>

    <li class="mt-2 nav-item <?= makeLinkActive('user.read.match_list') ?>">
        <a class="nav-link" href="<?= route('user.read.match_list') ?>">
            <!-- <i class="fas fa-users" style="color:white;content: url(/dist/blackfit/images/svg/matches.svg);width: 18px;height: 18px;top: 3px;position: relative;"></i> -->
            
            <svg width="18" height="18" viewBox="0 0 23 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M13.027 4.03308C13.7517 6.42769 12.8183 9.01313 10.7294 10.3971C12.4634 11.0352 13.9621 12.1837 15.027 13.6906C15.19 13.9215 15.2104 14.2237 15.0801 14.4744C14.9497 14.725 14.6902 14.8823 14.4071 14.8823L0.758285 14.8829C0.475181 14.8829 0.21565 14.7256 0.0852411 14.4749C-0.0451682 14.2243 -0.0247343 13.9221 0.138232 13.6912C1.20309 12.184 2.702 11.0353 4.43628 10.3971C2.34738 9.01313 1.41395 6.42769 2.13865 4.03308C2.86334 1.63846 5.07507 0 7.58282 0C10.0906 0 12.3023 1.63846 13.027 4.03308ZM20.4726 3.30772C21.6404 5.8439 20.7852 8.85062 18.456 10.3971C20.1901 11.0352 21.6888 12.1837 22.7536 13.6906C22.9166 13.9215 22.9371 14.2237 22.8067 14.4743C22.6763 14.725 22.4169 14.8823 22.1338 14.8823L17.8951 14.8829C17.6006 14.8829 17.3326 14.7128 17.208 14.4465C16.6254 13.2007 15.8052 12.0799 14.7931 11.1467C14.778 11.1327 14.7643 11.118 14.7506 11.1032C14.4859 10.8622 14.2093 10.6345 13.9219 10.4211C13.6069 10.1874 13.5228 9.75266 13.728 9.41891C15.2618 6.92095 15.1176 3.74356 13.364 1.39396C13.2149 1.19423 13.174 0.934126 13.2545 0.698436C13.335 0.462746 13.5266 0.281676 13.7669 0.214263C16.4607 -0.540433 19.3047 0.771547 20.4726 3.30772Z" fill="#FFFFFF"/>
            </svg>

            <span class="ml-1 pl-2"><?= __tr('Matches') ?></span>
        </a>
    </li>

    <li class="mt-2 nav-item <?= makeLinkActive('user.read.list_feed') ?>">
        <a class="nav-link" href="<?= route('user.read.list_feed',['username' => getUserAuthInfo('profile.username')]) ?>">
            <i class="fas fa-layer-group" style="color:white;font-size:18px;"></i>
            <span class="pl-2"><?= __tr('Feed') ?></span>
        </a>
    </li>

    <li class="mt-2 nav-item <?= makeLinkActive('user.read.pt_list') ?> <?= makeLinkActive('user.pt_profile_view') ?>">
        <a class="nav-link" href="<?= route('user.read.pt_list') ?>">
            <!-- <i class="fas fa-running" style="color:white;content: url(/dist/blackfit/images/svg/pts.svg);width: 18px;height: 18px;top: 3px;position: relative;"></i> -->
            
            <span>
                @if(Route::getCurrentRoute()->getName() == 'user.read.pt_list' || Route::getCurrentRoute()->getName() == 'user.pt_profile_view')
                <svg width="18" height="18" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="22" height="22" fill="url(#pattern0)"/>
                <defs>
                <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                <use xlink:href="#image0_1_2977" transform="scale(0.01)"/>
                </pattern>
                <image id="image0_1_2977" width="100" height="100" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAIvklEQVR4nO2db0xbVR/Hv7VlujWogWwuMQ5mHRNJWNQsG4ZHxhULa8sAcWxlJLxymZs65p8XxmWJPnlMNP5hI+Ie3+2xWRmb4gb94yytKBFdTHQkgwztSNUXOsNcJIzJqH1e1DIuvbfn3Hv75/77vNl6eu6vN/30nnvO75xzMcRiMejIh1tyfQI6bHQhMkMXIjN0ITJDFyIzdCEyQxciM0ykCgaDIRvnkXNi1dXsgubmfRgbexU//VQAs3kexcU/oqSkCS7XRc4Au3Y9hEikG5HIBly9ugxmcxR33/0LiovfwEcf/XehXjCY8jwMpIGhUoQkfaEJ2ttNMJvz0N09Sx3Mbj8Cv/9ZRKPs8lWrboBhHkVPz9es8sbGg/D7X8P169xf1iOPfIfNmzfhnXdukISot8nascOKsrJfceLEHD744Boslj/R1NRBPI5PBgBcvpyHYPAL7Ny5mVW+fPnnyM/nOOAfvvrqQYyMfEtz2uoU8uSTrfB6/bhw4S5cv27A/DwQDufjzJl3UV/fyXuc3X4EXi+3jARcUtzuYdTUVGPlynne40ZGyml+EOoT0tKyCz6fC9PTyc1HNAp4vfs5pTiddni9z4ImtydWSjj8Eim0uoQ4nbXw+T7EzAz/jY9PitvtQXW1l/qzxEiJRFaTwqpLyPnz/+O8MpbCJyUYtINhMidldpb4fatHSHu7CZcuraSunwspBQU3SOHUI8RszsP8vLA+eralrF07RgqlHiHd3bMoKpoWfFy2pNx2WwwWy25SGPUIAYDy8kMwGoUflw0pdXWH4HKdI4VQ30jd4XgLPt8LKccSfBgMgM12FB7P06zymprTCAS2UccpLJxHbS2D48e/THpPcyP1gYEXsXXr26KulFgM8Hr3wG5/n1UeCDSgpuYMdZypKRM+/TSI1tZ/CT0F9QkBFC1FnUIAxUpRrxBAkVLULQSIS7HZDouW4vfvSep9BQINgnpfU1MmBAKDaGtbT6qqfiEA0N/fIVpKOrvEExOnSdW0IQSQh5Tx8XWkKtoRAuReytychpKLtORSSlHRVVIV7QkBciPFaATKy18mhdemECAuRWyXOBoFBgb2J3WJg0E7Z5fYYADq6rpx6tRRUmjtCgGyM065mR/bRxM258lF3uU7mWLnzm3o6WH/iuvrO+H17heVkDQaAZvtMPr7O1jlDONBKGSDzdYFj+e5hXLNJRdTUV/fiZMnT6Oq6nNWebz56kz7PaWlxc6SQYF2rpD6+rfh9T6/cBVUVn6D4WH2+qpMpO4XVwmFQPq+tXGFLJUBAMPDm1BZyV6BmIl7ikDULyR+f3ie81c/PLwpqfmKSxHXfPHlvgSgbiHxKyP1zXpoqIrjSjmQhi7xe8IPVrMQrmaKj8w0X3vFSFGnkFTNFB8jI5vQ0tLIKpPefO2Fw/GukMPUJ0TMmCIxlujt/STpvXjzJb5L7PN1oLmZalAIqE2IFBlLB3aLkSpldPR12urqEZIpGQmkSLl06Xa0txN3qwFqEZJpGQnESsnLi+HYMf5tCotQvpBsyUggRkppaYS2qrKFZFtGAiFSCgujuP/+J2hDK1cIzaBvKYl5CSkyEtAMHu+8829YrQ1wu7+jDatMIWLGGUYj4HAcpp2XoCLVOKWwMIqtW2vhdnuEhFSekFw1U3wMDBxAY+MzWLfuTxiNwIoVMTz88CSs1o1wuwNCwykr/S4kHZIgnhbvpp6xC4XoY4tAPen3LMiQA1SDlaRfsdP5ICYmTuDnn4sxO2vEPfdM4YEHDtFM4otCbs1UBqESwsLprMHZs35MTd28k42NrcTFi+/D4ViPgYED6TxBLckAhDZZTmcN/H62jATRKODxdIidB+Ak113bHEAvxOncCL/fjz/+4O94i0w5cyKXrm2WoRcyPn4ypYwEiZSzFCkaa6YWI0RIEXVdKVI0LAOgFdLebsLcnLDIYqRoXAZAK+TYsXnce6+4Tfm0UnQZAIQ0WRs2vCJpGjOVFF3GAvRCPv64S9ISfj4pLS2NuoybCBuHSF3CzzVO6e39BFu2+KjjKHycQUJ4LisT65UGB2147DGyFAXmpoQiLrmYCykakAFIyfZmU4pGZABS0+/ZkKIhGQCFkKTU+44dNtZr6U9KSM59DQ7aUFU1pIbclFCEXSF2+xH09nrAMOx5Yqm7Wn2+jqQl/ENDW7B9e4Nae1N8EKdwwTDxf5fO2DHMZwgGray60ncgiW6aMj31mi7SM4XLNX0aDD4OhjnLqpejJfxqgiykuXkf77xEXAq7+UrHPUXCDiSlQxYyOvqflE1QMGhL+z2F73HgGoAsJBK5g1hHl5I2yEJuvfVvqki6lLRAFlJa+gN1NF2KZMhCSkoasGoV8ZnlC+hSJEEW4nJdhNVaKUIKu0uciafvqBC6cYjLdU6ElEyMUyQ/KUHu0KdOdClZQVguS5eScYSn33UpGYVOSGPjQTidlQuvXa5zYJhHRUhJd5plD9WfwlMQZCGtrRXw+f6NQCDEktLT87UIKenvEo+Ovib8QPlCFjI5eRR//QX8/rtJllIikXzs3btc+IHyhCwkHC5d+H82pAjdQrdsWQwzM/SfLXPIQq5cyWO9zryULkFXytq1l2mfkqAEyELM5uTkYialeDzPUTdf+fkxlJe3UX+eAiALWbPmN87ydEkJhWxwOu2sMpp7Sn5+DLW1bWK2HssZspD77nuT9z2pUuLz6F2cm+tTSUnIOHXqOPEzFAZZSF9fJyoqvud9X6yU+ILprpTPte3v78C2bQdgsUzDZIpvyi8r+w0Oh1WNMgDagWFJyUZUVJznfX962ojZ2S2sslRSjEagri61jAR9fZ0Ih2/H7t0rsH37Mly4sFptzdRi6JcBAUBTUwfC4ZcQiazGzMwtKCi4AYtlHBbLU7x/NLGtbT0mJvowObkO164ZsWbNFZSVHVy6p10py3ikQnxyBlGITlZRzqM1NIIuRGboQmSGLkRm6EJkhi5EZuhCZMb/AQ4Zvq/RGf4cAAAAAElFTkSuQmCC"/>
                </defs>
                </svg>

                @else
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="24" height="24" fill="url(#pattern0)"/>
                <defs>
                <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                <use xlink:href="#image0_1_1349" transform="scale(0.01)"/>
                </pattern>
                <image id="image0_1_1349" width="100" height="100" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAABmJLR0QA/wD/AP+gvaeTAAAEUUlEQVR4nO2dvW8URxiHLZD/BBo+HFKQBEHldImMXIY+MZbCX5HCKWgooeKrQkhpgtKRAlCUNBEioU/NR4jkSAEjg2xAOHcnPRRzVlbnubmd3Z2Z93K/p7T3497fczs3ezezMzcnhBBCCCGEEMIEwBLwC/AKeAJcBw4Etj8EXAT+ADaAR8D3wGc5X7d5gH3AfOQ+q0CfvTwGFjzbnwZee7bf5RKwv7uqphDgI+AOsA3sAA+A5Rr7jZOxy5NRKcBR4GlgH4Cr6ao1DrAIbHpC6QNnAvutAoMJwbaRMvEN8b8D+BR4GQjFKwU4XlNGGym38iVhAOBj/FdGXSlrEUKaSHmWLw0DAHcjwiwh5V2+NAqD601tR4aZW8rDfIkUBpjH9aZiySnlSr5EDIDr2jYhh5Rt4Ei+NAwALBO+hygp5Yt8SRgC+LKFlAFw1nPMbyKP8xfwYYn6TSIpBpEUg0iKQSTFIMCZFlK66n09JvB7ysxhRMqNErWbxYCUjRJ1m6awlLclajZPQSm/lqh3KiggpQd8XqLWqYF8XeIB8HWJGqeODFK824ghwAnP31I1XwNgNU9lU0gl+POe/60kkPJJnsqmEOCrkcAveLbpvPkSHjwyJKUUTP58yNJ8ibnglTFKiitF3dwqETIkJTU068b2gZOeY7VtvlZKZGCGFjJCg7DbSOkBSzkzMEMKGZVjt5HyW476TZFSRuUcTaX0gX0p6zdFDhmVczWRsp2ibpPklFE5Z6yUm13WbJYSMirnritlHTjYRb2mIf4+Azq+N8Ddp/QC5/sHON7V+cxCwSvD81pWxkhZB451fT5zWJJReU1LwP2hmC3c/HQ1U2PQVxgpkIwAwEHgO9zklA3gJxKOqMBgM2UG4BjuA2uUHgm+SJOMAEMZfweC6LpbqWZqHMDhCTKq787WVwq6MsIAP0QG01iKZNQAeNMgoGgpklED3FMSYh7M0kiKZEQA/N5ASG0pkhEJcKpBYLWkSEZDGgYXlAKclIwWkGBoDPBt22PMNAWlSMY4CkiRjElklCIZdckgRTJC4JmEQpre13nUmwrDf8+1XfP8L8W0sD3Tz8QQ9n4Vfs6zjUaL58AjQ1JKgRtRERp7lKX5EkOAezVClJRcAO9qhigpOQBeRIQoKakBbkSGKCkpAQ7gHk8nKVYAjjSQkqJLrEn5u0iKQSTFIJJiEEkpDG6dvqMjf1vAjX6PIUXva7ZWPgM+wI1afGpUyoN8aRgAuFYp3qKUHSJX8pxqPGGnlhI7ZHWLGXtKgm+hrZRSJi19OsrtfGkYAHg+JggLzdcmszD1uArwYyCQLqQM8EyuryFlE1jMl4QRcCufhWgjJfhc24CU2ZSxC3A5gZR+SEblOMu49Ql3cB/gt5m1ZmoU3ISdK4FwXwOnPfst4L+j79WRMXKseWapN1WH4bv1FvAM+HcY9lUCK1jifk+5DvyJW1b7Z7RKgBBCCCGEEEKY4T30nDoc+6o82wAAAABJRU5ErkJggg=="/>
                </defs>
                </svg>
                @endif
            </span>
            
            <span class="ml-1 pl-2"><?= __tr('PTs') ?></span>
        </a>
    </li>

    <li class="mt-2 nav-item <?= makeLinkActive('user.read.messenger') ?>">
        <a class="nav-link d-flex" href="<?= route('user.read.messenger') ?>">
            <!-- <i class="fas fa-comments" style="color:white;content: url(/dist/blackfit/images/svg/chat.svg);width: 18px;height: 18px;top: 3px;position: relative;"></i> -->
            <span>
                <svg width="18" height="18" viewBox="0 0 34 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M32.0128 24.1413C33.8625 20.7717 33.8861 16.7296 32.076 13.3396C30.2658 9.94972 26.8552 7.64897 22.9619 7.19143C21.246 3.27883 17.465 0.5995 13.1165 0.214582C8.76799 -0.170337 4.55349 1.80125 2.14213 5.34851C-0.269224 8.89576 -0.48842 13.4464 1.57136 17.1982L0.653336 20.3298C0.445889 21.0369 0.648183 21.7981 1.1818 22.3182C1.71541 22.8383 2.49645 23.0355 3.22214 22.8335L6.43616 21.9387C7.73675 22.6171 9.15588 23.0529 10.6206 23.2237C11.9298 26.2082 14.4646 28.5201 17.607 29.5959C20.7495 30.6717 24.2111 30.4126 27.1481 28.8818L30.362 29.7767C31.0876 29.9787 31.8686 29.7814 32.4023 29.2614C32.9359 28.7413 33.1383 27.9803 32.9309 27.2731L32.0128 24.1413ZM29.7139 23.4024C29.5467 23.6764 29.5029 24.0054 29.5927 24.3119L30.5006 27.4083L27.3231 26.5236C27.0086 26.4361 26.6711 26.4789 26.39 26.6417C24.1946 27.9096 21.5682 28.2639 19.1018 27.625C16.6355 26.986 14.5364 25.4074 13.277 23.2445C16.5654 22.9129 19.5625 21.2589 21.5457 18.6814C23.5289 16.104 24.3183 12.8369 23.7234 9.66793C26.6659 10.3453 29.1021 12.3466 30.2848 15.0582C31.4675 17.7697 31.2555 20.8679 29.7139 23.4024Z" fill="white"/>
                </svg>
            </span>
            <span  class="ml-1 pl-2"><?= __tr('Chat') ?></span>
        </a>
    </li>

    <li class="mt-2 nav-item  <?= makeLinkActive('user.notification.read.view') ?>">
        <a class="nav-link d-flex" href="<?= route('user.notification.read.view') ?>">
            <i class="fa fa-bell" style="color:white;font-size:18px;" aria-hidden="true"></i>
            <span class="pl-2"><?= __tr('Notifications') ?></span>
            @if(getNotificationList()['notificationCount'] > 0)
            <span class="chat-unread-count-badge" style="margin-left:auto;font-size:0.75rem!important;"><?= getNotificationList()['notificationCount'] ?> </span>
            @endif
            <span class="badge badge-danger badge-counter d-none" data-model="totalNotificationCount"><?= (getNotificationList()['notificationCount'] > 0) ? getNotificationList()['notificationCount'] : '5' ?></span>
        </a>
    </li>

    <li class="mt-2 nav-item <?= makeLinkActive('user.read.blocked_list') ?>">
        <a class="nav-link" href="<?= route('user.read.blocked_list') ?>">
            <!-- <i class="fas fa-ban" style="color:white;content: url(/dist/blackfit/images/svg/blocked.svg);width: 18px;height: 18px;top: 3px;position: relative;"></i> -->
            <span>  
                <svg width="18" height="18" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 0C4.2465 0 0 4.2465 0 9.5C0 14.7535 4.2465 19 9.5 19C14.7535 19 19 14.7535 19 9.5C19 4.2465 14.7535 0 9.5 0ZM14.25 12.9105L12.9105 14.25L9.5 10.8395L6.0895 14.25L4.75 12.9105L8.1605 9.5L4.75 6.0895L6.0895 4.75L9.5 8.1605L12.9105 4.75L14.25 6.0895L10.8395 9.5L14.25 12.9105Z" fill="white"/>
                </svg>
            </span>
            <span  class="ml-1 pl-2"><?= __tr('Blocked') ?></span>
        </a>
    </li>

    <li class="mt-2 nav-item <?= makeLinkActive('user.read.setting', ['pageType' => 'notification']) ?>">
        <a class="nav-link" href="<?= route('user.read.setting', ['pageType' => 'notification']) ?>">
            <!-- <i class="fas fa-cog" style="color:white;content: url(/dist/blackfit/images/svg/settings.svg);width: 18px;height: 18px;top: 3px;position: relative;"></i> -->
            <span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C12.6627 0 13.2 0.537258 13.2 1.2V1.308C13.2051 2.58024 13.9623 3.72367 15.1273 4.22297C16.3048 4.74272 17.6938 4.49086 18.6231 3.58184L18.7045 3.50053C18.9301 3.27472 19.2355 3.14811 19.554 3.14811C19.8725 3.14811 20.1779 3.27472 20.403 3.50006C20.6293 3.72608 20.7559 4.03151 20.7559 4.35C20.7559 4.66849 20.6293 4.97392 20.4039 5.199L20.3315 5.27147L20.1764 5.44167C19.485 6.25651 19.25 7.35081 19.533 8.36153L19.584 8.4C19.584 8.56252 19.617 8.72334 19.681 8.87272C20.1803 10.0377 21.3238 10.7949 22.5912 10.8L22.8 10.8C23.4627 10.8 24 11.3373 24 12C24 12.6627 23.4627 13.2 22.8 13.2H22.692C21.4198 13.2051 20.2763 13.9623 19.777 15.1273C19.2573 16.3048 19.5091 17.6938 20.4182 18.6231L20.4995 18.7045C20.7253 18.9301 20.8519 19.2355 20.8519 19.554C20.8519 19.8725 20.7253 20.1779 20.4999 20.403C20.2739 20.6293 19.9685 20.7559 19.65 20.7559C19.3315 20.7559 19.0261 20.6293 18.801 20.4039L18.7285 20.3315C17.7898 19.4131 16.4008 19.1613 15.2115 19.6862C14.0583 20.1803 13.3011 21.3238 13.296 22.5912L13.296 22.8C13.296 23.4627 12.7587 24 12.096 24C11.4333 24 10.896 23.4627 10.896 22.8V22.692C10.867 21.437 10.1341 20.3409 9.02625 19.8405L8.81422 19.7538C7.69522 19.2573 6.30619 19.5091 5.37688 20.4182L5.29547 20.4995C5.06992 20.7253 4.76449 20.8519 4.446 20.8519C4.12751 20.8519 3.82208 20.7253 3.597 20.4999C3.37072 20.2739 3.24411 19.9685 3.24411 19.65C3.24411 19.3315 3.37072 19.0261 3.59606 18.801L3.66853 18.7285C4.58686 17.7898 4.83872 16.4008 4.31384 15.2115C3.81967 14.0583 2.67624 13.3011 1.40879 13.296L1.2 13.296C0.537258 13.296 0 12.7587 0 12.096C0 11.4333 0.537258 10.896 1.2 10.896H1.308C2.56302 10.867 3.65913 10.1341 4.15951 9.02625L4.24624 8.81422C4.74272 7.69522 4.49086 6.30619 3.58184 5.37688L3.50053 5.29547C3.27472 5.06992 3.14811 4.76449 3.14811 4.446C3.14811 4.12751 3.27472 3.82208 3.50006 3.597C3.72608 3.37072 4.03151 3.24411 4.35 3.24411C4.66849 3.24411 4.97392 3.37072 5.199 3.59606L5.27147 3.66853L5.44167 3.82365C6.25651 4.51504 7.35081 4.75002 8.36153 4.46702L8.4 4.416C8.56252 4.416 8.72334 4.38299 8.87272 4.31897C10.0377 3.81967 10.7949 2.67624 10.8 1.40879L10.8 1.2C10.8 0.537258 11.3373 0 12 0Z" fill="white"/>
            <path id="setting_circle" d="M12 7C9.23858 7 7 9.23858 7 12C7 14.7614 9.23858 17 12 17C14.7614 17 17 14.7614 17 12C17 9.23858 14.7614 7 12 7Z" fill="#191919"/>
            <path d="M12 10C13.1046 10 14 10.8954 14 12C14 13.1046 13.1046 14 12 14C10.8954 14 10 13.1046 10 12C10 10.8954 10.8954 10 12 10Z" fill="white"/>
            </svg>

            </span>
            <span  class="ml-1 pl-2"><?= __tr('Settings') ?></span>
        </a>
    </li>
    
    @if(getUserAuthInfo('profile.role_id') == 3)
    <li class="mt-2 nav-item <?= makeLinkActive('user.read.sponser-ad') ?>">
        <a class="nav-link" href="<?= route('user.read.sponser-ad') ?>">
            <span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 3.6C0 1.61177 1.61177 0 3.6 0H6C6.66274 0 7.2 0.537258 7.2 1.2C7.2 1.86274 6.66274 2.4 6 2.4H3.6C2.93726 2.4 2.4 2.93726 2.4 3.6V6C2.4 6.66274 1.86274 7.2 1.2 7.2C0.537258 7.2 0 6.66274 0 6V3.6Z" fill="#fff"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 20.4C0 22.3882 1.61177 24 3.6 24H6C6.66274 24 7.2 23.4627 7.2 22.8C7.2 22.1373 6.66274 21.6 6 21.6H3.6C2.93726 21.6 2.4 21.0627 2.4 20.4V18C2.4 17.3373 1.86274 16.8 1.2 16.8C0.537258 16.8 0 17.3373 0 18V20.4Z" fill="#fff"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M24 20.4C24 22.3882 22.3882 24 20.4 24H18C17.3373 24 16.8 23.4627 16.8 22.8C16.8 22.1373 17.3373 21.6 18 21.6H20.4C21.0627 21.6 21.6 21.0627 21.6 20.4V18C21.6 17.3373 22.1373 16.8 22.8 16.8C23.4627 16.8 24 17.3373 24 18V20.4Z" fill="#fff"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M24 3.6C24 1.61177 22.3882 0 20.4 0H18C17.3373 0 16.8 0.537258 16.8 1.2C16.8 1.86274 17.3373 2.4 18 2.4H20.4C21.0627 2.4 21.6 2.93726 21.6 3.6V6C21.6 6.66274 22.1373 7.2 22.8 7.2C23.4627 7.2 24 6.66274 24 6V3.6Z" fill="#fff"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 0C12.6627 0 13.2 0.537258 13.2 1.2V2.47427C17.5425 3.01577 20.9842 6.45754 21.5257 10.8H22.8C23.4627 10.8 24 11.3373 24 12C24 12.6627 23.4627 13.2 22.8 13.2H21.5257C20.9842 17.5425 17.5425 20.9842 13.2 21.5257V22.8C13.2 23.4627 12.6627 24 12 24C11.3373 24 10.8 23.4627 10.8 22.8V21.5257C6.45754 20.9842 3.01577 17.5425 2.47427 13.2H1.2C0.537258 13.2 0 12.6627 0 12C0 11.3373 0.537258 10.8 1.2 10.8H2.47427C3.01577 6.45754 6.45754 3.01577 10.8 2.47427V1.2C10.8 0.537258 11.3373 0 12 0ZM12 19.2C15.9764 19.2 19.2 15.9764 19.2 12C19.2 8.02355 15.9764 4.8 12 4.8C8.02355 4.8 4.8 8.02355 4.8 12C4.8 15.9764 8.02355 19.2 12 19.2Z" fill="white"/>
                <path d="M15.6 12C15.6 13.9882 13.9882 15.6 12 15.6C10.0118 15.6 8.4 13.9882 8.4 12C8.4 10.0118 10.0118 8.4 12 8.4C13.9882 8.4 15.6 10.0118 15.6 12Z" fill="#fff"/>
                </svg>
            </span>
            <span class="ml-1 pl-2"><?= __tr('Sponsored Ad') ?></span>
        </a>
    </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider mt-2 mb-2">
    <li style="display:none;" class="nav-item <?= makeLinkActive('user.photos_setting') ?>">
        <a class="nav-link" href="<?= route('user.photos_setting', ['username' => getUserAuthInfo('profile.username')]) ?>">
            <i class="far fa-images"></i>
            <span  class="ml-1"><?= __tr('My Photos') ?></span>
        </a>
    </li>

    <!-- Divider -->
    <li class="nav-item1" style="margin-top: auto;margin-bottom:130px;">
        <a class="btn btn-secondary" style="background: #616161;border-radius: 14px;border: none;box-shadow:none;" href="#" data-toggle="modal" data-target="#supportModal">
            <!-- <i class="fas fa-comment-dots" style="color:white;content: url(/dist/blackfit/images/svg/support.svg);width: 18px;height: 18px;top: 3px;position: relative;"></i> -->
            <span>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.1169 3.03039e-05H9.61693C8.14208 -0.0037243 6.68472 0.341464 5.36607 1.00752C2.15179 2.61395 0.118318 5.90212 0.116926 9.49973L0.123219 9.86808C0.163813 10.9716 0.399414 12.0594 0.81816 13.0806L0.923926 13.3251L0.228596 15.0032C-0.0843567 15.7583 -0.0756534 16.6084 0.252693 17.3569L0.328166 17.5163C1.04434 18.9218 2.74201 19.5409 4.20512 18.8991L5.80293 18.1971L6.03643 18.2989C7.17113 18.7642 8.38839 19.0033 9.61953 19.0001C13.2149 18.9987 16.5031 16.9652 18.1114 13.7472C18.7756 12.4323 19.1208 10.9749 19.117 9.49755L19.117 9.00011C18.8542 4.21065 15.1382 0.410857 10.4391 0.0200158L10.1169 3.03039e-05ZM9.61438 2.00003L10.0749 1.99911L10.0618 1.99851C13.8687 2.20861 16.9084 5.24834 17.1185 9.05521L17.117 9.50011C17.12 10.6651 16.8484 11.8117 16.3243 12.8493C15.0527 15.3936 12.4568 16.999 9.61654 17.0001C8.45195 17.0031 7.30531 16.7316 6.26778 16.2075C6.0013 16.0729 5.68862 16.0644 5.41522 16.1843L3.40171 17.0676C2.89594 17.2894 2.30609 17.0593 2.08423 16.5535C1.97478 16.304 1.97188 16.0206 2.0762 15.7689L2.94073 13.683C3.05229 13.4138 3.0409 13.1094 2.90952 12.8493C2.38547 11.8117 2.11389 10.6651 2.11692 9.50272C2.11802 6.66029 3.7234 4.06436 6.26398 2.79462C7.30528 2.26867 8.45194 1.99707 9.61438 2.00003Z" fill="white"/>
                </svg>
            </span>

            <span><?= __tr('Support') ?></span>
        </a>
    </li>

    <li class="nav-item" style="">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class=" d-none fas fa-sign-out-alt"></i>
            <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13.0165 5.38948V4.45648C13.0165 2.42148 11.3665 0.771484 9.33146 0.771484H4.45646C2.42246 0.771484 0.772461 2.42148 0.772461 4.45648V15.5865C0.772461 17.6215 2.42246 19.2715 4.45646 19.2715H9.34146C11.3705 19.2715 13.0165 17.6265 13.0165 15.5975V14.6545" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M19.8096 10.0214H7.76855" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M16.8818 7.10632L19.8098 10.0213L16.8818 12.9373" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

            <?= __tr('Logout') ?>
        </a>
    </li>

    <!-- Featured Users -->
    @if(!__isEmpty(getFeatureUserList()))
    <div class="card" style="display:none;">
        <div class="card-header">
            <?= __tr('Featured Users') ?>
        </div>
        <div class="card-body lw-featured-users">
            @foreach(getFeatureUserList() as $users)
            <a href="<?= route('user.profile_view', ['username' => $users['username']]) ?>">
                <img class="img-fluid img-thumbnail lw-sidebar-thumbnail lw-lazy-img" data-src="<?= $users['userImageUrl'] ?>">
            </a>
            @endforeach
        </div>
    </div>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block" style = "margin-bottom:50px;">
    @endif
    <!-- /Featured Users -->

    <!-- sidebar advertisement -->
    @if(!getFeatureSettings('no_adds') and getStoreSettings('user_sidebar_advertisement')['status'] == 'true')
    <li class="nav-item lw-sidebar-ads-container d-none d-md-block">
        <!-- sidebar advertisement content -->
        <div>
            <?= getStoreSettings('user_sidebar_advertisement')['content'] ?>
        </div>
        <!-- /sidebar advertisement content -->
    </li>
    <!-- sidebar advertisement -->
    @endif
    <!-- Sidebar Toggler (Sidebar) -->
</ul>
<!-- End of Sidebar -->
