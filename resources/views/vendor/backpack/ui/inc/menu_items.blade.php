{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-question" :link="backpack_url('user')" />
<x-backpack::menu-item title="Companies" icon="la la-question" :link="backpack_url('company')" />
<x-backpack::menu-item title="Offers" icon="la la-question" :link="backpack_url('offer')" />
<x-backpack::menu-item title="Applications" icon="la la-question" :link="backpack_url('application')" />
<x-backpack::menu-item title="Cities" icon="la la-question" :link="backpack_url('city')" />
<x-backpack::menu-item title="Classes" icon="la la-question" :link="backpack_url('classe')" />
<x-backpack::menu-item title="Departments" icon="la la-question" :link="backpack_url('department')" />
<x-backpack::menu-item title="Regions" icon="la la-question" :link="backpack_url('region')" />
<x-backpack::menu-item title="Sectors" icon="la la-question" :link="backpack_url('sector')" />
<x-backpack::menu-item title="Skills" icon="la la-question" :link="backpack_url('skill')" />
<x-backpack::menu-item title="Statuses" icon="la la-question" :link="backpack_url('status')" />
<x-backpack::menu-item title="Roles" icon="la la-question" :link="backpack_url('role')" />

<x-backpack::menu-item title="Permissions" icon="la la-question" :link="backpack_url('permission')" />