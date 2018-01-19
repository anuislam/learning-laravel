<!-- Catalog menu - start -->
                <div class="topcatalog">
                    <a class="topcatalog-btn" href="catalog-list.html"><span>All</span> catalog</a>
                    <ul class="topcatalog-list">
                @php
                echo str_replace('<i class="fa fa-angle-right"></i><ul></ul>', '', allstor_get_menu_catalog(NULL, 3));
                @endphp
                    </ul>
                </div>
                <!-- Catalog menu - end -->

                <!-- Main menu - start -->

                <ul class="mainmenu">

                @php
                echo str_replace('<ul class="sub-menu"></ul>', '', allstor_get_menu_top(NULL, 2));
                @endphp
                
                </ul>
                <!-- Main menu - end -->

                <!-- Search - start -->
                <div class="topsearch">
                    <a id="topsearch-btn" class="topsearch-btn" href="#"><i class="fa fa-search"></i></a>
                    <form class="topsearch-form" action="#">
                        <input type="text" placeholder="Search products">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <!-- Search - end -->