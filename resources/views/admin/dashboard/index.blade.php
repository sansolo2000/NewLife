@extends('admin.layouts.master')

@section('title', 'Jiras')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            @include('admin.dashboard.menu')
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        @if ($menu == 1 || $menu == 2 || $menu == 4)
          @include("admin.dashboard.indicadores_jira")
        @endif
        @if ($menu == 3 || $menu == 5)
          @include("admin.dashboard.indicadores_versiones")
        @endif
  
        <!-- /.row -->
        <!-- Main row -->

        @if ($menu == 2 || $menu == 4)
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Ultimas actividades - Jiras
                </h3>

              </div><!-- /.card-header -->

              <div class="card-body">
                <div class="row">
                  <div class="col-lg-3">
                    Fecha
                  </div>
                  <div class="col-lg-3">
                    Jira
                  </div>
                  <div class="col-lg-6">
                    Descripción
                  </div>
                </div>    
                @include("admin.dashboard.jirasacciones")            
              </div><!-- /.card-body -->
            </div>
          </section>
        </div>
        @endif
        @if ($menu == 3 || $menu == 5)
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Ultimas actividades - Versiones
                  </h3>

                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-3">
                      Fecha
                    </div>
                    <div class="col-lg-3">
                      Versiones
                    </div>
                    <div class="col-lg-6">
                      Descripción
                    </div>
                  </div>    
                  @include("admin.dashboard.versionesacciones")            
                </div><!-- /.card-body -->
              </div>
            </section>
          </div>
        @endif


        @if ($menu == 1)
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Ultimas actividades - Jiras
                </h3>

              </div><!-- /.card-header -->

              <div class="card-body">
                <div class="row">
                  <div class="col-lg-3">
                    Fecha
                  </div>
                  <div class="col-lg-3">
                    Jira
                  </div>
                  <div class="col-lg-6">
                    Descripción
                  </div>
                </div>    
                @include("admin.dashboard.jirasacciones")            
              </div><!-- /.card-body -->
            </div>
          </section>
        </div>

          <div class="row">
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Ultimas actividades - Versiones
                  </h3>

                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-3">
                      Fecha
                    </div>
                    <div class="col-lg-3">
                      Versiones
                    </div>
                    <div class="col-lg-6">
                      Descripción
                    </div>
                  </div>    
                  @include("admin.dashboard.versionesacciones")            
                </div><!-- /.card-body -->
              </div>
            </section>
          </div>
        @endif
          <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  
  @endsection