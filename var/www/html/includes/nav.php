 
    
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

                <div class="navbar-header">

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="<?=$_GeniSys->_confs["domainString"]; ?>/dashboard">GeniSys v<?=$_GeniSys->_confs["version"]; ?></a>
                    
                </div>

                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown"><i class="fa fa-clock fa-fw"></i> <div id="clock"></div></li>
                </ul>
    
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li class="sidebar-search">
                                <div class="input-group custom-search-form">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                                </div>
                            </li>
                            <li>
                                <a href="<?=$_GeniSys->_confs["domainString"]; ?>/dashboard"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            </li>
                            <li>
                                <a href="<?=$_GeniSys->_confs["domainString"]; ?>/Server/"><i class="fa fa-cloud fa-fw"></i> Server</a>
                            </li>
                            <li>
                                <a href="<?=$_GeniSys->_confs["domainString"]; ?>/iotJumpWay/"><i class="fa fa-th fa-fw"></i> iotJumpWay</a>
                            </li>
                            <li>
                                <a href="<?=$_GeniSys->_confs["domainString"]; ?>/NLU/"><i class="fa fa-commenting-o fa-fw"></i> NLU</a>
                            </li>
                            <li>
                                <a href="<?=$_GeniSys->_confs["domainString"]; ?>/TASS/"><i class="fa fa-eye fa-fw"></i> TASS Local</a>
                            </li>
                            <li>
                                <a href="<?=$_GeniSys->_confs["domainString"]; ?>/TASS/Foscam"><i class="fa fa-eye fa-fw"></i> TASS Foscam</a>
                            </li>
                            <li>
                                <a href="<?=$_GeniSys->_confs["domainString"]; ?>/Users/"><i class="fa fa-users fa-fw"></i> Users</a>
                            </li>
                            <li>
                                <a href="<?=$_GeniSys->_confs["domainString"]; ?>/<?=$_GeniSys->_confs["phpmyadmin"]; ?>" target="_BLANK"><i class="fa fa-database fa-fw"></i> phpMyAdmin</a>
                            </li>
                            <li>
                                <a href="https://github.com/GeniSysAI/Server" target="_BLANK"><i class="fa fa-github-square fa-fw"></i> GitHub</a>
                            </li>
                            <li>
                                <a href="<?=$_GeniSys->_confs["domainString"]; ?>/logout"><i class="fa fa-power-off fa-fw"></i> Log out</a>
                            </li>
                        </ul> 
                    </div> 
                    
                </div>
                
            </nav>