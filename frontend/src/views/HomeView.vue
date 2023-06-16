<template>
  <v-app>
    <div class="table-container">
      <v-data-table
        :headers="headers"
        :items="employees"
        sort-by="f_name"
        class="elevation-1"
      >
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>Employees</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  color="primary"
                  dark
                  class="mb-2"
                  v-bind="attrs"
                  v-on="on"
                >
                  New Employee
                </v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="text-h5">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.f_name"
                          label="First Name"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.l_name"
                          label="Last Name"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.other_name"
                          label="Other Name"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.email"
                          label="Email"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.mobile_contact"
                          label="Mobile Contact"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.home_contact"
                          label="Home Contact"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.dob"
                          label="Date of Birth"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.joining_date"
                          label="Joining Date"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.next_of_kin"
                          label="Next of Kin's Name"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.next_of_kin_contact"
                          label="Next of Kin's Contact"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="close">
                    Cancel
                  </v-btn>
                  <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
            <v-dialog v-model="dialogDelete" max-width="500px">
              <v-card>
                <v-card-title class="text-h5"
                  >Are you sure you want to delete this item?</v-card-title
                >
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="closeDelete"
                    >Cancel</v-btn
                  >
                  <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                    >OK</v-btn
                  >
                  <v-spacer></v-spacer>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>
        </template>
        <template v-slot:[`item.actions`]="{ item }">
          <v-btn small class="mr-2" @click="editItem(item)">edit</v-btn>
          <v-btn @click="deleteItem(item)">delete</v-btn>
        </template>
        <template v-slot:no-data>
          <v-btn color="primary"> Reset </v-btn>
        </template>
      </v-data-table>
    </div>
  </v-app>
</template> 

<script>
import EmployeeService from "@/services/employee.js";
export default {
  data: () => ({
    dialog: false,
    dialogDelete: false,
    headers: [
      {
        text: "First Name",
        align: "start",
        sortable: false,
        value: "f_name",
      },
      { text: "Last Name", value: "l_name" },
      { text: "Other Name", value: "other_name" },
      { text: "email", value: "email" },
      { text: "obile Contact", value: "mobile_contact" },
      { text: "Actions", value: "actions", sortable: false },
    ],
    employees: [],
    editedIndex: -1,
    editedItem: {
      f_name: "",
      l_name: "",
      other_name: "",
      email: "",
      mobile_contact: "",
      home_contact: "",
      dob: "",
      joining_date: "",
      next_of_kin: "",
      next_of_kin_contact: "",
    },
    defaultItem: {
      f_name: "",
      l_name: "",
      other_name: "",
      email: "",
      mobile_contact: "",
      home_contact: "",
      dob: "",
      joining_date: "",
      next_of_kin: "",
      next_of_kin_contact: "",
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Employee" : "Edit Employee";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.getAllEmployees();
  },

  methods: {
    editItem(item) {
      this.editedIndex = this.employees.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.employees.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.deleteAnEmployee(this.editedItem.id);
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        EmployeeService.updateEmployee(this.editedItem).then(
          (response) => {
            this.getAllEmployees();
            console.log(response.data.data, "response create");
          },
          (error) => {
            alert("Something went a mess");
            console.log(error.response);
          }
        );
      } else {
        EmployeeService.createEmployee(this.editedItem).then(
          (response) => {
            this.getAllEmployees();
            console.log(response.data.data, "response create");
          },
          (error) => {
            alert("Something went a mess");
            console.log(error.response);
          }
        );
      }
      this.close();
    },

    getAllEmployees() {
      EmployeeService.getAllEmployees().then(
        (response) => {
          this.employees = response.data.data;
        },
        (error) => {
          alert("Something went a mess");
          console.log(error.response);
        }
      );
    },

    deleteAnEmployee(id) {
      EmployeeService.deleteEmployee(id).then(
        (response) => {
          this.closeDelete();
          this.getAllEmployees();
          console.log(response.data.data, "response delete");
        },
        (error) => {
          alert("Something went a mess");
          console.log(error.response);
        }
      );
    },
  },
};
</script>

<style scoped>
.table-container {
  display: flex;
  justify-content: center;
}

.v-data-table {
  width: 70%;
}
</style>


