<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/admin/public/img/user.png" class="img-circle" alt="">
            </div>
            <div class="pull-left info">
                <p><?php echo $data['user']['login'] ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <form action="/admin/search/" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Global search">
                <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>

        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Navigation</li>
            <li class="side-nav-item" data-item="report">
                <a href="/admin/report">
                    <i class="fa fa-line-chart"></i>
                    <span>Summary</span>
                </a>
            </li>
            <li class="treeview side-nav-item" data-item="content">
                <a href="#">
                    <i class="fa fa-newspaper-o"></i> <span>Content</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview">
                        <a href="#"><i class="fa fa-newspaper-o"></i> Posts
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="#" onclick="contentAdd()">
                                    <i class="fa fa-plus"></i> Add
                                </a>
                            </li>
                            <li>
                                <a href="/admin/content">
                                    <i class="fa fa-newspaper-o"></i> All entries
                                </a>
                            </li>
                            <li>
                                <a href="/admin/content/not-category">
                                    <i class="fa fa-folder-o"></i> No category
                                </a>
                            </li>
                            <li>
                                <a href="/admin/content/active">
                                    <i class="fa fa-eye"></i> Published
                                </a>
                            </li>
                            <li>
                                <a href="/admin/content/inactive">
                                    <i class=" "></i> Hidden
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-folder"></i> Categories
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="#" onclick="categoryAdd()">
                                    <i class="fa fa-plus"></i> Add
                                </a>
                            </li>
                            <li>
                                <a href="/admin/category">
                                    <i class="fa fa-folder"></i> View all
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-tags"></i> Tags
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="#" onclick="tagAdd()">
                                    <i class="fa fa-plus"></i> Add
                                </a>
                            </li>
                            <li>
                                <a href="/admin/tags">
                                    <i class="fa fa-tags"></i> View all
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-comments-o"></i> Comments
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="/admin/comments">
                                    <i class="fa fa-comments-o"></i> View all
                                </a>
                            </li>
                            <li>
                                <a href="/admin/comments/active">
                                    <i class="fa fa-eye"></i> Published
                                </a>
                            </li>
                            <li>
                                <a href="/admin/comments/inactive">
                                    <i class="fa fa-eye-slash"></i> Hidden
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="treeview side-nav-item" data-item="pages">
                <a href="#">
                    <i class="fa fa-clone"></i> <span>Pages</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="#" onclick="pageAdd()">
                            <i class="fa fa-file-o"></i> New page
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="galleryAdd()">
                            <i class="fa fa-file-image-o"></i> New gallery
                        </a>
                    </li>
                    <li>
                        <a href="/admin/pages">
                            <i class="fa fa-clone"></i> View all
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview side-nav-item" data-item="subscriptions">
                <a href="#">
                    <i class="fa fa-send-o"></i> <span>Newsletters</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="#" onclick="subscriptionsNew();">
                            <i class="fa fa-send"></i> New newsletter
                        </a>
                    </li>
                    <li>
                        <a href="/admin/subscriptions">
                            <i class="fa fa-send-o"></i> All subscribers
                        </a>
                    </li>
                    <li>
                        <a href="/admin/subscriptions/active">
                            <i class="fa fa-eye"></i> Active
                        </a>
                    </li>
                    <li>
                        <a href="/admin/subscriptions/inactive">
                            <i class="fa fa-eye-slash"></i> Inactive
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview side-nav-item" data-item="formdata">
                <a href="#">
                    <i class="fa fa-database"></i> <span>Form data</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="/admin/formdata">
                            <i class="fa fa-database"></i> All requests
                        </a>
                    </li>
                    <li>
                        <a href="/admin/formdata/not-viewed">
                            <i class="fa fa-eye-slash"></i> Not viewed
                        </a>
                    </li>
                    <li>
                        <a href="/admin/formdata/viewed">
                            <i class="fa fa-eye"></i> Viewed
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview side-nav-item" data-item="statistics">
                <a href="#">
                    <i class="fa fa-bar-chart"></i> <span>Statistics</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="/admin/statistics">
                            <i class="fa fa-eye"></i> View
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview side-nav-item" data-item="templates">
                <a href="#">
                    <i class="fa fa-paint-brush"></i> <span>Template</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="/admin/templates">
                            <i class="fa fa-paint-brush"></i> Template selection
                        </a>
                    </li>
                    <li>
                        <a href="/admin/templates/edit">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview side-nav-item" data-item="users">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="#" onclick="userAdd();">
                            <i class="fa fa-plus"></i> Add
                        </a>
                    </li>
                    <li>
                        <a href="/admin/users">
                            <i class="fa fa fa-users"></i> Users
                        </a>
                    </li>
                    <li>
                        <a href="/admin/users/logs">
                            <i class="fa fa fa-tasks"></i> User actions
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview side-nav-item" data-item="messages">
                <a href="#">
                    <i class="fa fa-envelope"></i> <span>Messages</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="#" onclick="messageAdd();">
                            <i class="fa fa-send-o"></i> To write
                        </a>
                    </li>
                    <li>
                        <a href="/admin/messages">
                            <i class="fa fa-inbox"></i> Inbox
                        </a>
                    </li>
                    <li>
                        <a href="/admin/messages/outbox">
                            <i class="fa fa-send"></i> Outgoing
                        </a>
                    </li>
                    <li>
                        <a href="/admin/messages/unread">
                            <i class="fa fa-envelope"></i> Unread
                        </a>
                    </li>
                </ul>
            </li>
            <li class="side-nav-item" data-item="chat">
                <a href="/admin/chat">
                    <i class="fa fa-commenting-o"></i>
                    <span>Internal chat</span>
                </a>
            </li>
            <li class="treeview side-nav-item" data-item="settings">
                <a href="#">
                    <i class="fa fa-sliders"></i> <span>Settings</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="/admin/settings">
                            <i class="fa fa-sliders"></i> Settings
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
</aside>