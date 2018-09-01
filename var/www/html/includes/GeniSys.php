
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