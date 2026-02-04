<style>
    .my-account {
        padding-top: 50px;
        padding-bottom: 80px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        color: #111;
        margin-bottom: 30px;
        letter-spacing: -0.5px;
    }

    /* Left Sidebar Navigation */
    .account-nav {
        list-style: none;
        padding: 0;
        border: 1px solid #efefef;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
    }

    .account-nav li {
        /* border-bottom: 1px solid #efefef; */
    }

    .account-nav li:last-child {
        border-bottom: none;
    }

    .menu-link_us-s {
        display: block;
        padding: 15px 20px;
        font-size: 14px;
        font-weight: 600;
        color: #666;
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
        /* ডিফল্ট ট্রান্সপারেন্ট বর্ডার */
    }

    .menu-link_us-s:hover {
        background: #fcfcfc;
        color: #000;
        text-decoration: none;

    }

    /* একটিভ ক্লাসের স্টাইল */
    .menu-link_us-s.active {
        background: #fcfcfc;
        color: #000;
        border-left: 4px solid #000;
    }

   
    .menu-link_us-s::after {
        display: none !important;
        content: none !important;
        width: 0 !important;
    }

    /* হোভার করলেও যেন ফিরে না আসে */
    .menu-link_us-s:hover::after,
    .menu-link_us-s.active::after {
        display: none !important;
        width: 0 !important;
    }
</style>
<ul class="account-nav shadow-sm" id="account-menu">
    <li><a href="{{ route('user.index') }}"
            class="menu-link menu-link_us-s {{ request()->routeIs('user.index') ? 'active' : '' }}">Dashboard</a>
    </li>
    <li><a href="{{ route('user.orders') }}"
            class="menu-link menu-link_us-s {{ request()->routeIs('user.orders') ? 'active' : '' }}">Orders</a>
    </li>
    <li><a href="{{ route('user.address') }}"
            class="menu-link menu-link_us-s {{ request()->routeIs('user.address*') ? 'active' : '' }}">Addresses</a>
    </li>
    <li><a href="{{ route('user.account.details') }}"
            class="menu-link menu-link_us-s {{ request()->routeIs('user.account.details') ? 'active' : '' }}">Account
            Details</a></li>
    <li><a href="{{ route('user.wishlist') }}"
            class="menu-link menu-link_us-s {{ request()->routeIs('user.wishlist') ? 'active' : '' }}">Wishlist</a>
    </li>
    <li>
        <form action="{{ route('logout') }}" method="post" id="logout-form">
            @csrf
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit()"
                class="menu-link menu-link_us-s text-danger">Logout</a>
        </form>
    </li>
</ul>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // ১. Active Class Manipulation via JS
        const menuLinks = document.querySelectorAll('.menu-link_us-s');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                menuLinks.forEach(item => item.classList.remove('active'));
                this.classList.add('active');
            });
        })
    });
</script>
