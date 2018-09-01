
                        
                        <div class="panel panel-default">
                
                            <div class="panel-heading">
                
                                <i class="fa fa-exclamation fa-fw"></i> Server Info
                
                            </div>
                            
                            <div class="panel-body">
                            
                                <div class="list-group">
                                    <a class="list-group-item"> 
                                        SERVER IP <span class="pull-right text-muted small"><em><?=$_SERVER['SERVER_ADDR']; ?></em></span>
                                    </a>
                                </div>
                                
                                <div class="list-group">
                                    <a class="list-group-item"> 
                                        SERVER HOME <span class="pull-right text-muted small"><em><?=$_SERVER['HOME']; ?></em></span>
                                    </a>
                                </div>
                                
                                <div class="list-group">
                                    <a class="list-group-item"> 
                                        SERVER USER <span class="pull-right text-muted small"><em><?=$_SERVER['USER']; ?></em></span>
                                    </a>
                                </div>
                                
                                <div class="list-group">
                                    <a class="list-group-item"> 
                                        SERVER SOFTWARE <span class="pull-right text-muted small"><em><?=$_SERVER['SERVER_SOFTWARE']; ?></em></span>
                                    </a>
                                </div>
                                
                                <div class="list-group">
                                    <a class="list-group-item"> 
                                        SERVER GATEWAY <span class="pull-right text-muted small"><em><?=$_SERVER['GATEWAY_INTERFACE']; ?></em></span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                
                            <div class="panel-heading">
                
                                <i class="fa fa-exclamation fa-fw"></i> GeniSys Info
                
                            </div>
                            
                            <div class="panel-body">
                                
                                <div class="list-group">
                                    <a class="list-group-item">
                                        GENISYS VERSION <span class="pull-right text-muted small"><em><?=$_GeniSys->_confs['version']; ?></em></span>
                                    </a>
                                </div>
                                
                                <div class="list-group">
                                    <a class="list-group-item">
                                        NLU <span class="pull-right text-muted small"><em><?=$_GeniSys->_confs['nluID'] ? "Setup Complete" : "Setup Required"; ?></em></span>
                                    </a>
                                </div>
                                
                                <div class="list-group">
                                    <a class="list-group-item">
                                        TASS <span class="pull-right text-muted small"><em><?=$_GeniSys->_confs['tassID'] ? "Setup Complete" : "Setup Required"; ?></em></span>
                                    </a>
                                </div>
                
                            </div>
                            
                        </div> 