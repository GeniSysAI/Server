 
    
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">

                <div class="navbar-header">

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/dashboard"><?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs['meta_title']); ?> (GeniSys Server v<?=$_GeniSys->_confs["version"]; ?>)</a>
                    
                </div>
                
                <div class="navbar-right">
                    <span id="date_time"></span>
                </div>
    
                <div class="navbar-default sidebar" id="hideNav" role="navigation">
                    <div class="sidebar-nav navbar-collapse"> 
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/dashboard">&nbsp;&nbsp;<i class="fa fa-home fa-fw"></i>&nbsp;Dashboard</a>
                            </li>
                            <li>
                                <a href="#">&nbsp;&nbsp;<i class="fa fa-superpowers fa-fw"></i> <?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs['meta_title']); ?> Core<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">  
                                    <li><a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Server/">&nbsp;&nbsp;<i class="fa fa-server fa-fw"></i>&nbsp;&nbsp;&nbsp;Server</a></li>  
                                    <li><a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Connectivity/">&nbsp;&nbsp;<i class="fa fa-th fa-fw"></i>&nbsp;&nbsp;&nbsp;Connectivity</a></li>
                                    <li>
                                        <a href="#">&nbsp;&nbsp;<i class="fa fa-microchip fa-fw"></i>&nbsp;&nbsp; AI Core<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                             <li><a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/AIcore/Language/">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Language</a></li>
                                            <li><a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/AIcore/Vision/">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vision</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["phpmyadmin"]); ?>" target="_BLANK">&nbsp;&nbsp;<i class="fa fa-database fa-fw"></i>&nbsp;&nbsp;&nbsp;Database</a></li>
                                    <li>
                                        <a href="#">&nbsp;&nbsp;<i class="fa fa-users fa-fw"></i>&nbsp;&nbsp; Users<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <li><a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Users/Admins">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Admins</a></li>
                                            <li><a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Users/Guests">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guests</a></li>
                                            <li><a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Users/Unknown">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unknown</a></li>
                                            <li><a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Users/">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Users</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">&nbsp;&nbsp;<i class="fa fa-globe fa-fw"></i> Connectivity<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/Connectivity/Live">&nbsp;&nbsp;<i class="fa fa-globe fa-fw"></i>&nbsp;&nbsp;&nbsp;Live</a></li>
                                </ul>
                            </li>
                            <li><a href="https://github.com/GeniSysAI/Server" target="_BLANK">&nbsp;&nbsp;<i class="fa fa-github-square fa-fw"></i>&nbsp;&nbsp;GitHub</a></li>
                            <li><a href="https://www.iotjumpway.tech/console/" target="_BLANK">&nbsp;&nbsp;<i class="fa fa-th fa-fw"></i>&nbsp;&nbsp;iotJumpWay</a></li>
                            <li><a href="<?=$_GeniSys->_helpers->decrypt($_GeniSys->_confs["domainString"]); ?>/logout">&nbsp;&nbsp;<i class="fa fa-power-off fa-fw"></i>&nbsp;&nbsp;&nbsp;Log out</a></li>
                        </ul> 
                    </div> 
                    
                </div>
                
            </nav>