
                        
                        <div class="panel panel-default">
                
                            <div class="panel-heading">
                
                                <i class="fa fa-exclamation fa-fw"></i> TASS Device Info
                
                            </div>
                            
                            <div class="panel-body">

                                <div class="list-group">
                                    <a class="list-group-item">
                                        ID <span class="pull-right text-muted small"><em><?=$device != null ? $device->ResponseData->id : "NA"; ?></em></span>
                                    </a>
                                </div>

                                <div class="list-group">
                                    <a class="list-group-item">
                                        STATUS <span class="pull-right text-muted small"><em><?=$device != null ? $device->ResponseData->onlineStatus == "" ? "OFFLINE" : $device->ResponseData->onlineStatus : "NA"; ?></em></span>
                                    </a>
                                </div>

                                <div class="list-group">
                                    <a class="list-group-item">
                                        LOCATION <span class="pull-right text-muted small"><em><?=$device != null ? "#".$device->ResponseData->lcnid : "NA"; ?></em></span>
                                    </a>
                                </div>

                                <div class="list-group">
                                    <a class="list-group-item">
                                        FLOOR <span class="pull-right text-muted small"><em><?=$device != null ? $device->ResponseData->flrid : "NA"; ?></em></span>
                                    </a>
                                </div>

                                <div class="list-group">
                                    <a class="list-group-item">
                                        ZONE <span class="pull-right text-muted small"><em><?=$device != null ? $device->ResponseData->zneid : "NA"; ?></em></span>
                                    </a>
                                </div>

                                <div class="list-group">
                                    <a class="list-group-item">
                                        NAME <span class="pull-right text-muted small"><em><?=$device != null ? $device->ResponseData->device : "NA"; ?></em></span>
                                    </a>
                                </div>

                                <div class="list-group">
                                    <a class="list-group-item">
                                        LAST UPDATED <span class="pull-right text-muted small"><em><?=$device != null ? $device->ResponseData->lastUpdated == 0 ? "NA" : date("Y-m-d H:i:s", $device->ResponseData->lastUpdated) : "NA"; ?></em></span>
                                    </a>
                                </div>

                            </div>
                            
                        </div> 