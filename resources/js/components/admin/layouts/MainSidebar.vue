<template>
  <aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
      <a class="desktop-logo logo-light active" href="#"></a>
      <a class="desktop-logo logo-dark active" href="#"></a>
      <a class="logo-icon mobile-logo icon-light active" href="#"></a>
      <a class="logo-icon mobile-logo icon-dark active" href="#"></a>
    </div>
    <div class="main-sidemenu">
      <div class="app-sidebar__user clearfix">
        <div class="dropdown user-pro-body">
          <div class="">
            <img alt="user-img" class="avatar avatar-xl brround" src="/assets/img/logo_muhib.jpg" /><span
              class="avatar-status profile-status bg-green"></span>
          </div>
          <div class="user-info">
            <h4 class="font-weight-semibold mt-3 mb-0">{{ username }}</h4>
            <span class="mb-0 text-muted"><br />{{ email }}</span>
          </div>
        </div>
      </div>
      <ul class="side-menu">
        <!-- <li class="slide">
          <router-link class="side-menu__item" to="/ExampleComponent"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon"
              viewBox="0 0 24 24"
            >
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path
                d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z"
                opacity=".3"
              />
              <path
                d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"
              /></svg
            ><span class="side-menu__label"> ExampleComponent</span
            ><span class="badge badge-success side-badge">1</span></router-link
          >
        </li> -->

        <li class="side-item side-item-category">Main</li>
        <li class="slide">
          <router-link class="side-menu__item" to="dashboard"><svg xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon" viewBox="0 0 24 24">
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
              <path
                d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
            </svg><span class="side-menu__label">لوحه التحكم</span><span
              class="badge badge-success side-badge">1</span></router-link>
        </li>



        <!--<li class="side-item side-item-category">General</li> -->
        <!-- 
        <li class="slide">
          <router-link class="side-menu__item" data-toggle="slide" to="/group"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon"
              viewBox="0 0 24 24"
            >
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path
                d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"
                opacity=".3"
              />
              <path
                d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"
              /></svg
            ><span class="side-menu__label">مجموعات الاصناف</span
            ><i class="angle fe fe-chevron-down"></i
          ></router-link>
          <router-link class="side-menu__item" data-toggle="slide" to="/category"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon"
              viewBox="0 0 24 24"
            >
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path
                d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"
                opacity=".3"
              />
              <path
                d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"
              /></svg
            ><span class="side-menu__label">الاصناف</span
            ><i class="angle fe fe-chevron-down"></i
          ></router-link>

          <router-link class="side-menu__item" data-toggle="slide" to="/store"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon"
              viewBox="0 0 24 24"
            >
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path
                d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"
                opacity=".3"
              />
              <path
                d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"
              /></svg
            ><span class="side-menu__label">اماكن الاصناف</span
            ><i class="angle fe fe-chevron-down"></i
          ></router-link>

          <!-- <router-link class="side-menu__item" data-toggle="slide" to="status"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon"
              viewBox="0 0 24 24"
            >
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path
                d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"
                opacity=".3"
              />
              <path
                d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"
              /></svg
            ><span class="side-menu__label">حاله المنتج</span
            ><i class="angle fe fe-chevron-down"></i
          ></router-link> -->

        <!-- <router-link class="side-menu__item" data-toggle="slide" to="Type_product"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon"
              viewBox="0 0 24 24"
            >
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path
                d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"
                opacity=".3"
              />
              <path
                d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"
              /></svg
            ><span class="side-menu__label">ProductType</span
            ><i class="angle fe fe-chevron-down"></i
          ></router-link> -->

        <!--<router-link class="side-menu__item" data-toggle="slide" to="/product"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon"
              viewBox="0 0 24 24"
            >
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path
                d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"
                opacity=".3"
              />
              <path
                d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"
              /></svg
            ><span class="side-menu__label">المنتجات</span
            ><i class="angle fe fe-chevron-down"></i
          ></router-link>
          <router-link class="side-menu__item" to="/user"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon"
              viewBox="0 0 24 24"
            >
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path
                d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"
                opacity=".3"
              />
              <path
                d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"
              /></svg
            ><span class="side-menu__label">العملاء</span
            ><i class="angle fe fe-chevron-down"></i
          ></router-link>
          <router-link class="side-menu__item" to="/supplier"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon"
              viewBox="0 0 24 24"
            >
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path
                d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"
                opacity=".3"
              />
              <path
                d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"
              /></svg
            ><span class="side-menu__label">الموردين</span
            ><i class="angle fe fe-chevron-down"></i
          ></router-link>
        </li> -->

        <!-- <li class="slide">
          <a class="side-menu__item" data-toggle="slide" href=""
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon"
              viewBox="0 0 24 24"
            >
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path
                d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                opacity=".3"
              />
              <path
                d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"
              /></svg
            ><span class="side-menu__label">Supply</span
            ><i class="angle fe fe-chevron-down"></i
          ></a>
          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="supply">Supply</router-link>
            </li>
          </ul>
        </li> -->

        <!--  -->

        <li class="slide">
          <a class="side-menu__item" data-toggle="slide" href=""><svg xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon" viewBox="0 0 24 24">
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                opacity=".3" />
              <path
                d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
            </svg><span class="side-menu__label">الاعدادات </span><i class="angle fe fe-chevron-down"></i></a>


          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/user">المستخدمين</router-link>
            </li>

            
            <li>
              <router-link class="slide-item" to="/groups">انواع التصنيفات</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/groups">التصنيفات</router-link>
            </li>

            <li class="slide">
              <router-link class="slide-item" to="/financial_accounting/mark_accounts">
                ترميز الجسابات </router-link>
            </li>

            <li>
              <router-link class="slide-item" to="/company">بيانات الشركه</router-link>
            </li>
          </ul>

        </li>
        <li class="slide">
          <a class="side-menu__item" data-toggle="slide" href=""><svg xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon" viewBox="0 0 24 24">
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                opacity=".3" />
              <path
                d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
            </svg><span class="side-menu__label">محاسبة مالية</span><i class="angle fe fe-chevron-down"></i></a>

          <ul class="slide-menu">




            <li class="slide">
              <router-link class="slide-item" to="/accounts_basic_data">البيانات الاساسيه </router-link>
            </li>
       

            <li class="slide">
              <router-link class="slide-item" to="/financial_accounting/setting_account">
                ربط الجسابات </router-link>
            </li>

            <li class="slide">
              <router-link class="slide-item" to="accounts_guide">الدليل المجاسبي</router-link>
            </li>
            <li class="slide">
              <router-link class="slide-item" to="daily_restrictions">
                قيود اليوميه</router-link>
            </li>

            <li>
              <router-link class="slide-item" to="/expence">المصروفات والايرادات</router-link>
            </li>
            <li class="slide">
              <router-link class="slide-item" to="/account_list">
                دفتر الاستاذ العام</router-link>
            </li>

            <!-- <li>
              <router-link class="slide-item" to="/income">الايرادات </router-link>
            </li> -->
            <!-- <li class="slide">
              <router-link class="slide-item" to="auditBalance">
                دفتر الاستاذ العام</router-link>
            </li> -->
            <li class="slide">
              <router-link class="slide-item" to="auditBalance">
                ميزان المراجعه</router-link>
            </li>
            <li class="slide">
              <router-link class="slide-item" to="auditBalance">
                الارباح والخسائر</router-link>
            </li>
            <li class="slide">
              <router-link class="slide-item" to="/closing_year"> الاقفالات السنويه </router-link>
            </li>
            <li class="slide">
              <router-link class="slide-item" to="/closing_year"> الاقفالات الشهريه </router-link>
            </li>

          </ul>
        </li>
        <li class="slide">
          <a class="side-menu__item" data-toggle="slide" href=""><svg xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon" viewBox="0 0 24 24">
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                opacity=".3" />
              <path
                d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
            </svg><span class="side-menu__label">الموارد البشريه</span><i class="angle fe fe-chevron-down"></i></a>

          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/staff/basic_data">
                البيانات الاساسيه</router-link>
            </li>
          </ul>
          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/tree_structure">الهيكل الاداري </router-link>
            </li>
          </ul>


          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/staff/operation">ِشؤون الموظفين</router-link>
            </li>
          </ul>
          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/staff/salary_wage">الرواتب والاجور</router-link>
            </li>
          </ul>
          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/staff/attendance"> الحضور والغياب</router-link>
            </li>
          </ul>

          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/staff/sanction">لوائح الحضور والغياب</router-link>
            </li>
          </ul>

          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/staff/staff_sanction"> مكافئات وجزاءات الحضور والغياب</router-link>
            </li>
          </ul>

          <!-- <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/staff/salary">الرواتب</router-link>
            </li>
          </ul> -->

          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/staff/staff">التقارير</router-link>
            </li>
          </ul>


          <!-- <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/staff/operation">العمليات</router-link>
            </li>
          </ul> -->

          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/staff/report">التقارير</router-link>
            </li>
          </ul>
        </li>



        <li class="slide">
          <a class="side-menu__item" data-toggle="slide" href=""><svg xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon" viewBox="0 0 24 24">
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                opacity=".3" />
              <path
                d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
            </svg><span class="side-menu__label">اداره المخازن</span><i class="angle fe fe-chevron-down"></i></a>

          <!-- <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/product"> اعدادات المخازن</router-link>
            </li>
          </ul> -->
          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/product"> المنتجات</router-link>
            </li>
          </ul>

          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/unit">الوحدات</router-link>
            </li>
          </ul>

          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/store">المخازن</router-link>
            </li>
          </ul>

          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/stock">المخزون</router-link>
            </li>
          </ul>
          <ul class="slide-menu">
          <li>
              <router-link class="slide-item" to="/newcash">امر صرف مخزني</router-link>
            </li>
          </ul>
          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/listcash">اوامر الصرف</router-link>
            </li>
          </ul>
          <ul class="slide-menu">
          <li>
              <router-link class="slide-item" to="/newsupply">امر توريد مخزني</router-link>
            </li>
          </ul>
   
          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/listsupply">اوامر التوريد</router-link>
            </li>
          </ul>

          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/newtransfer">تحويل مخزني</router-link>
            </li>
          </ul>

          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/listtransfer">التحويلات المخزنيه</router-link>
            </li>
          </ul>

          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/newrecive">استلام تحويل مخزني</router-link>
            </li>
          </ul>


          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/opening_inventory">المخزون الافتتاحي</router-link>
            </li>
          </ul>
          <!-- <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/recive">استلام مخزني</router-link>
            </li>
          </ul> -->

          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="pricing">التسعيره </router-link>
            </li>

          </ul>
        </li>

        <!-- <li class="slide">
          <a class="side-menu__item" data-toggle="slide" href=""><svg xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon" viewBox="0 0 24 24">
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                opacity=".3" />
              <path
                d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
            </svg><span class="side-menu__label">الوارد </span><i class="angle fe fe-chevron-down"></i></a>
          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/supply">اضافه وارد</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/supplylist">الواردات</router-link>
            </li>

         
          </ul>
        </li> -->

        <!-- <li class="slide">
          <a class="side-menu__item" data-toggle="slide" href=""><svg xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon" viewBox="0 0 24 24">
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                opacity=".3" />
              <path
                d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
            </svg><span class="side-menu__label">الصرف </span><i class="angle fe fe-chevron-down"></i></a>
          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/cash">اضافه صرف</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/cashlist">المصروفات</router-link>
            </li>
          </ul>
        </li> -->

        <li class="slide">
          <a class="side-menu__item" data-toggle="slide" href=""><svg xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon" viewBox="0 0 24 24">
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                opacity=".3" />
              <path
                d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
            </svg><span class="side-menu__label">اداره المشتريات </span><i class="angle fe fe-chevron-down"></i></a>
          <ul class="slide-menu">
         
            <li>
              <router-link class="slide-item" to="/newpurchase"> فاتوره مشتريات</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/newpurchasereturn"> فاتوره مردودات مشتريات</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/listpurchase">المشتريات</router-link>
            </li>
    
            <!-- <li>
              <router-link class="slide-item" to="/purchases">مردودات المشتريات </router-link>
            </li> -->

            <li>
              <router-link class="slide-item" to="/PaymentBondList">سندات الصرف</router-link>
            </li>
          </ul>
        </li>
        <li class="slide">
          <a class="side-menu__item" data-toggle="slide" href=""><svg xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon" viewBox="0 0 24 24">
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                opacity=".3" />
              <path
                d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
            </svg><span class="side-menu__label">اداره الموردين </span><i class="angle fe fe-chevron-down"></i></a>
          <ul class="slide-menu">
        
            <li>
              <router-link class="slide-item" to="/supplier_setting">تجهيز الموردين</router-link>
            </li>
        
            <li>
              <router-link class="slide-item" to="/supplier">الموردين</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/supplier_account_list">حساب الموردين</router-link>
            </li>
         
          </ul>
        </li>

        <li class="slide">
          <a class="side-menu__item" data-toggle="slide" href=""><svg xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon" viewBox="0 0 24 24">
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                opacity=".3" />
              <path
                d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
            </svg><span class="side-menu__label">اداره المبيعات </span><i class="angle fe fe-chevron-down"></i></a>
          <ul class="slide-menu">

          
            <li>
              <router-link class="slide-item" to="/newsale">فاتوره مبيعات</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/newsalereturn"> فاتوره مردودات مبيعات</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/listsale"> المبيعات</router-link>
            </li>
<!--           
            <li>
              <router-link class="slide-item" to="/listsale"> مردودات المبيعات</router-link>
            </li> -->


            <li>
              <router-link class="slide-item" to="/ReceivableBondList">سندات القبض</router-link>
            </li>
          </ul>
        </li>
        <li class="slide">
          <a class="side-menu__item" data-toggle="slide" href=""><svg xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon" viewBox="0 0 24 24">
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                opacity=".3" />
              <path
                d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
            </svg><span class="side-menu__label">اداره العملاء </span><i class="angle fe fe-chevron-down"></i></a>
          <ul class="slide-menu">
         

            <li>
              <router-link class="slide-item" to="/customer_setting">تجهيز العملاء</router-link>
            </li>
          
            <li>
              <router-link class="slide-item" to="/customer">العملاء</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/customer_account_list">حساب العملاء</router-link>
            </li>
       
          </ul>
        </li>
        <!-- <li class="slide">
          <a class="side-menu__item" data-toggle="slide" href=""><svg xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon" viewBox="0 0 24 24">
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                opacity=".3" />
              <path
                d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
            </svg><span class="side-menu__label">اداره المبيعات </span><i class="angle fe fe-chevron-down"></i></a>
          <ul class="slide-menu">

            <li>
              <router-link class="slide-item" to="/customer_setting">تجهيز العملاء</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/customer_group">تصنيفات العملاء</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/customer">العملاء</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/customer_account_list">حساب العملاء</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/newsale">فاتوره مبيعات</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/listsale"> المبيعات</router-link>
            </li>

            <li>
              <router-link class="slide-item" to="/listsale"> مردودات المبيعات</router-link>
            </li>


            <li>
              <router-link class="slide-item" to="/ReceivableBondList ">سندات القبض</router-link>
            </li>
          </ul>
        </li> -->

        <li class="slide">
          <a class="side-menu__item" data-toggle="slide" href=""><svg xmlns="http://www.w3.org/2000/svg"
              class="side-menu__icon" viewBox="0 0 24 24">
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                opacity=".3" />
              <path
                d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
            </svg><span class="side-menu__label">التقارير</span><i class="angle fe fe-chevron-down"></i></a>
          <ul class="slide-menu">
            <li>
              <router-link class="slide-item" to="/reportstock"> المخزون</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/movements">حركه الاصناف</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/sales">المبيعات</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/sales">مردودات المبيعات </router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/purchases">المشتريات</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/purchases">مردودات المشتريات </router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/reportsupply">الوارد</router-link>
            </li>
            <!-- <li>
              <router-link class="slide-item" to="reportsupplyreturn"
                >مرتجع الوارد</router-link
              >
            </li> -->

            <li>
              <router-link class="slide-item" to="/reportcashing">الصرف</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/reportcashing">التحويل المخزني</router-link>
            </li>
            <li>
              <router-link class="slide-item" to="/try"> try</router-link>
            </li>
            <!-- <li>
              <router-link class="slide-item" to="reportstock"
                >المخزون</router-link
              >
            </li> -->

            <!-- <li>
              <router-link class="slide-item" to="yem">yem</router-link>
            </li> -->
          </ul>
        </li>
      </ul>
    </div>
  </aside>
</template>

<script>
export default {
  data() {
    return {
      username: "",
      email: "",
    };
  },
  mounted() {
    this.axios.post("/user_name").then((response) => {
      this.username = response.data.user.name;
      this.email = response.data.user.email;
    });
  },
};
</script>