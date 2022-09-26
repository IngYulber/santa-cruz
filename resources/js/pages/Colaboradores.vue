<template>
  <div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Colaboradores</h1>
    <div class="my-2">
      <a
        href="#"
        class="btn btn-primary btn-icon-split btn-sm"
        data-toggle="modal"
        data-target="#registerModal"
      >
        <span class="icon text-white-50">
          <fa icon="plus" />
        </span>
        <span class="text">Registrar Colaborador</span>
      </a>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Colaboradores</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table
            class="table table-bordered"
            id="dataTable"
            width="100%"
            cellspacing="0"
          >
            <thead>
              <tr>
                <th>Nombres</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Opciones</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>
                  <a href="#" class="btn btn-warning btn-circle">
                    <fa icon="edit" />
                  </a>
                  <a href="#" class="btn btn-danger btn-circle">
                    <fa icon="trash" />
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Logout Modal-->
    <div
      class="modal fade"
      id="registerModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Formulario de registro
            </h5>
            <button
              class="close"
              type="button"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="user">
              <div class="form-group row">
                <div class="col-sm-12 my-2">
                  <input
                    type="text"
                    class="form-control form-control-user"
                    id="exampleFirstName"
                    placeholder="Nombres"
                  />
                </div>
                <div class="col-sm-12 my-2">
                  <input
                    type="text"
                    class="form-control form-control-user"
                    id="exampleLastName"
                    placeholder="Apellidos"
                  />
                </div>
                <div class="col-sm-12 my-2">
                  <input
                    type="email"
                    class="form-control form-control-user"
                    id="exampleInputEmail"
                    placeholder="DNI"
                  />
                </div>
                <div class="col-sm-12 my-2">
                  <input
                    type="password"
                    class="form-control form-control-user"
                    id="exampleInputPassword"
                    placeholder="Contraseña"
                  />
                </div>
                <div class="col-sm-12 my-2">
                  <input
                    type="password"
                    class="form-control form-control-user"
                    id="exampleRepeatPassword"
                    placeholder="Confirmar contraseña"
                  />
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              class="btn btn-secondary"
              type="button"
              data-dismiss="modal"
            >
              Cancelar
            </button>
            <btn class="btn btn-primary">registrar</btn>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>
