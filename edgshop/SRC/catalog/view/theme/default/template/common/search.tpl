            <div class="search-input" id="search">
                    <div class="flexsearch" style="display: none;">
                                <div class="flexsearch--wrapper">
                                        <form class="flexsearch--form" action="/product/search" method="get">
                                                <div class="flexsearch--input-wrapper" style="font-size: 12px;">
                                                        <input class="flexsearch--input" type="search" name="search"  value="<?php echo $search; ?>" placeholder="<?php echo $text_search; ?>" style="">
                                                </div>
                                                <!--<input class="flexsearch--submit" type="submit" value="➜">-->
                                                <button class="flexsearch--submit" >
                                                        <span class="glyphicon glyphicon-search" aria-hidden="true" style=""></span>
                                                </button>
                                                <button id="dropdownMenu1" class="flexsearch--drop" data-toggle="dropdown">
                                                        所有类别
                                                </button>
                                                <!-- <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="right:0;left: inherit;">
                                                    <li><a href="#">Action</a></li>
                                                    <li><a href="#">Another action</a></li>
                                                    <li><a href="#">Something else here</a></li>
                                                    <li><a href="#">Separated link</a></li>
                                                </ul> -->
                                        </form>    
                                </div>
                        </div>
            </div>