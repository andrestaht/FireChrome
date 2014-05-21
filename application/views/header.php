<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="et">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<title>FireChrome</title>
		<link href="<?php echo base_url() . "assets/css/reset.css" ?>" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url() . "assets/css/style.css" ?>" rel="stylesheet" type="text/css">
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
		<link rel="icon" href="<?php echo base_url() . "assets/img/favicon.ico?v=2" ?>">
		<script src="<?php echo base_url() . "assets/js/jquery.min.js" ?>" type="text/javascript" ></script>
		<script src="<?php echo base_url() . "assets/js/global.js" ?>" type="text/javascript" ></script>
	</head>
	<body class="no-js">
		<div id="menu-bar">
            <div class="wrap">
                <div id="menu-button"><span></span></div>
                <ul>
				<?php foreach ($menu_data as $menu_item) { ?>
					<li class="menu-item"><a id="menu-item-<?php echo $menu_item->id ?>" href="<?php echo base_url() . "main/index/" . $menu_item->id ?>"><?php echo $menu_item->name ?></a></li>
				<?php } ?>				
				</ul>
                <div id="header-login">
                    <?php if (empty($session_data['is_logged_in'])) { ?>
                    <a id="login" href="<?php echo base_url() . "login" ?>" title="Logi Sisse"></a>
                    <a id="register" href="<?php echo base_url() . "register" ?>" title="Registreeri"></a>
                    <?php } else { ?>                        
                    <a id="logout" href="<?php echo base_url() . "main/logout" ?>" title="Logi välja"></a>  
                    <?php if (empty($session_data['is_facebook_account'])) { ?>
                    <a id="settings" href="javascript:void(0);" title="Seaded"></a>
                    <ul>
                        <li>
                            <?php if ($wants_newsletter) { ?>
                            <a class="change-newletter-link" href="<?php echo base_url() . 'user_control/remove_newsletter_subscription/' . $session_data['user_id'] ?>">Loobun uudiskirjast</a>
                            <?php } else { ?>
                            <a class="change-newletter-link" href="<?php echo base_url() . 'user_control/add_newsletter_subscription/' . $session_data['user_id'] ?>">Liitun uudiskirjaga</a>
                            <?php } ?>
                        </li>
                        <li>
                            <?php if ($session_data['level'] > 5) { ?>
                            <a id="usercontrol" href="<?php echo base_url() . "user_control" ?>">Halda Kasutajaid</a>
                            <?php } ?>
                        </li>
                        <li>
                            <a id="change-password-link" href="<?php echo base_url() . "user_control/change_password" ?>">Muuda parooli</a>
                        </li>
                    </ul>
                    <?php } ?>                  
                    <p id="user"><?php echo $session_data['username']; ?></p>
                    <?php } ?>
                </div>                
            </div>
        </div>
		<div class="wrap">
			<div id="header">
				<div id="header-left">
					<a href="<?php echo base_url() . "main/index/1" ?>"><span id="logo"></span></a>
				</div>
				<div id="header-right">
					<div id="search-form">
                        <?php
                            $form_entry = array('entry' => 's_entry');
    
                            echo form_open('search_results');
    
                            echo "<div>";
                            echo form_input('s_result', $this->input->post('s_result'));
                            echo form_submit('search_results');
                            echo "</div>";
    
                            echo form_close();
                        ?>
                    </div>
					<!--div id="current-time">
					</div-->
					<?php if ($session_data['level'] > 1) { ?>
					<a id="add-news-btn" href="<?php echo base_url() . "news/add_news" ?>">Lisa uudis</a>
					<a id="write-newsletter-btn" href="<?php echo base_url() . "main/write_newsletter" ?>">Koosta uudiskiri</a>
				<?php } ?>
					
				</div>
			</div>
			
			<div id="content">