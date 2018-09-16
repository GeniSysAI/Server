
                        
                        <div class="panel panel-default">
                
                            <div class="panel-heading">
                
                                <i class="fa fa-exclamation fa-fw"></i> TASS Foscam Device Actions
                
                            </div>
                            
                            <div class="panel-body">

                                <div class="list-group">
                                    <a href="<?=$_GeniSys->_confs["domainString"]; ?>/TASS/FoscamEdit?device=<?=abs($tassFoscam["ResponseData"]["id"]); ?>" class="list-group-item">
                                        <i class="fa fa-edit fa-1x"></i> Edit TASS Foscam Device #<?=abs($tassFoscam["ResponseData"]["id"]); ?>
                                    </a>
                                </div>

                                <div class="list-group">
                                    <a href="<?=$_GeniSys->_confs["domainString"]; ?>/TASS/FoscamStream?device=<?=abs($tassFoscam["ResponseData"]["id"]); ?>" class="list-group-item">
                                        <i class="fa fa-eye fa-1x"></i> View TASS Foscam Stream #<?=abs($tassFoscam["ResponseData"]["id"]); ?>
                                    </a>
                                </div>

                            </div>

                        </div>