
 
                        
                        <div class="panel panel-default">
                
                            <div class="panel-heading">
                
                                <i class="fa fa-exclamation fa-fw"></i> User Info
                
                            </div>
                            
                            <div class="panel-body">
                            
                                <div class="list-group">
                                    <a class="list-group-item"> 
                                        ID <span class="pull-right text-muted small"><em><?=$user["ResponseData"]["id"]; ?></em></span>
                                    </a>
                                </div>
                                
                                <div class="list-group">
                                    <a class="list-group-item"> 
                                        Mood <span class="pull-right text-muted small"><em><?=$user["ResponseData"]["mood"]; ?></em></span>
                                    </a>
                                </div>
                                
                                <div class="list-group">
                                    <a class="list-group-item"> 
                                        Last Seen <span class="pull-right text-muted small"><em><?=date("Y-m-d H:i:s", $user["ResponseData"]["lastSeen"]); ?></em></span>
                                    </a>
                                </div>
                                
                                <div class="list-group">
                                    <a class="list-group-item"> 
                                        Last Location <span class="pull-right text-muted small"><em><?=$user["ResponseData"]["lastLocation"]; ?></em></span>
                                    </a>
                                </div>
                                
                                <div class="list-group">
                                    <a class="list-group-item"> 
                                        Last Floor <span class="pull-right text-muted small"><em><?=$user["ResponseData"]["lastFloor"]; ?></em></span>
                                    </a>
                                </div>
                                
                                <div class="list-group">
                                    <a class="list-group-item"> 
                                        Last Zone <span class="pull-right text-muted small"><em><?=$user["ResponseData"]["lastZone"]; ?></em></span>
                                    </a>
                                </div>
                            </div>
                        </div>