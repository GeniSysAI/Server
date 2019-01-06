
                        
                        <div class="panel panel-default">
                
                            <div class="panel-heading">
                
                                <i class="fa fa-exclamation fa-fw"></i> Connectivity Information
                
                            </div>
                            
                            <div class="panel-body">

                                <div class="list-group">
                                    <a class="list-group-item">
                                        APP <span class="pull-right text-muted small"><em><?=$_GeniSys != null ? $_GeniSys->_confs["jumpwayAppID"] != "" ? "#".$_GeniSys->_helpers->decrypt($_GeniSys->_confs["jumpwayAppID"]) : "Setup Required" : "NA"; ?></em></span>
                                    </a>
                                </div>
                                
                                <div class="list-group">
                                    <a class="list-group-item">
                                        LOCATION <span class="pull-right text-muted small"><em><?=$_GeniSys != null ? $_GeniSys->_confs["jumpwayLocation"] != "" ? "#".$_GeniSys->_helpers->decrypt($_GeniSys->_confs["jumpwayLocation"]) : "Setup Required" : "NA"; ?></em></span>
                                    </a>
                                </div>
                                
                            </div>

                        </div>