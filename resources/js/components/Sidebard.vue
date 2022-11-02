<template>
  <ul
    class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
    id="accordionSidebar"
  >
    <!-- Sidebar - Brand -->
    <a
      class="sidebar-brand d-flex align-items-center justify-content-center"
      href="panel"
    >
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Santa Cruz</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="/panel">
        <fa icon="home" /><span class="mx-2">Panel</span></a
      >
    </li>

    <li class="nav-item active">
      <a class="nav-link" href="/colaboradores">
        <fa icon="users" /><span class="mx-2">Colaboradores</span></a
      >
    </li>

    <li class="nav-item active">
      <a class="nav-link" href="/cobranza"
        ><fa icon="receipt" /> <span class="mx-2">Cobranza</span></a
      >
    </li>

    <li class="nav-item active">
      <a class="nav-link" href="/reuniones"
        ><fa icon="handshake" /> <span class="mx-2">Reuniones</span></a
      >
    </li>

    <li class="nav-item active">
      <a class="nav-link" href="/sanciones">
        <fa icon="ban" /> <span class="mx-2">Sanciones</span></a
      >
    </li>
    <hr class="sidebar-divider d-none d-md-block" />

    <li class="nav-item active">
      <a class="nav-link" href="/reportes">
        <fa icon="download" /> <span class="mx-2">Reportes</span></a
      >
    </li>
  </ul>
</template>

<script>
export default {};
</script>

<style>
</style>
