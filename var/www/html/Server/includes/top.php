
                
                <div class="row">

                    <div class="col-lg-3 col-md-6">

                        <div class="panel panel-primary">

                            <div class="panel-heading">

                                <div class="row">

                                    <div class="col-xs-3">

                                        <i class="fa fa-microchip fa-5x"></i>

                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <div class="huge">CPU</div>
                                        <div><span id="cpu"><?=$_GeniSys->getCPULoad(); ?></span>%</div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-lg-3 col-md-6">

                        <div class="panel panel-primary">

                            <div class="panel-heading">

                                <div class="row">

                                    <div class="col-xs-3">

                                        <i class="fa fa-microchip fa-5x"></i>

                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <div class="huge">Temperature</div>
                                        <div><span id="temperature"><?=$_GeniSys->getTemperature(); ?></span></div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-lg-3 col-md-6">

                        <div class="panel panel-primary">

                            <div class="panel-heading">

                                <div class="row">

                                    <div class="col-xs-3">

                                        <i class="fa fa-microchip fa-5x"></i>

                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <div class="huge">Memory</div>
                                        <div><span id="memory"><?=$_GeniSys->getMemoryUsage(); ?></span>%</div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    
                    </div>
                    <div class="col-lg-3 col-md-6">
                        
                        <div class="panel panel-primary">

                            <div class="panel-heading">

                                <div class="row">

                                    <div class="col-xs-3">

                                        <i class="fa fa-microchip fa-5x"></i>

                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <div class="huge">Swap</div>
                                        <div><span id="memory"><?=$_GeniSys->getSwap(); ?></span>%</div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>