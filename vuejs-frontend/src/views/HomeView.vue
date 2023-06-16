<template>
  <div>
    <h2>Task Manager</h2>
    <div v-if="list.length > 0">
      <button @click="toggleAddTask" class="btn-add-close">
        {{ formToggleMessage }}
      </button>
      <p v-if="!formToggle"> 
        <small>Clicking this will open a form toggle</small>
      </p>
      <div v-if="formToggle">
        <input type="text" placeholder="Enter task" v-model="t_name" />
        <input type="submit" @click="handlesAddTask" />
      </div>

      <h2>Draggable Task</h2>
      <p>Drag and drop to reorder</p>
      <draggable
        v-model="list"
        :disabled="!enabled"
        ghost-class="ghost"
        class="list-group"
        :move="checkMove"
        @start="drag = true"
        @end="onEnd"
      >
        <transition-group>
          <div
            class="list-group-item"
            v-for="element in list"
            :key="element.id"
          >
            {{ element.t_name }}

            <button @click="handlesDeleteTask(element)" class="btn-delete">
              Delete
            </button>
          </div>
        </transition-group>
      </draggable>
    </div>
  </div>
</template> 

<script>
import draggable from "vuedraggable";

import axios from "axios";
const instance = axios.create({
  baseURL: "http://localhost/task-manager/laravel-backend-apis/public/api",
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
});
export default {
  name: "SimpleDraggable",
  display: "Simple",
  order: 0,

  components: {
    draggable,
  },

  created() {
    this.getList();
  },

  data() {
    return {
      enabled: true,
      oldList: [],
      list: [],
      listSend: [],
      dragging: false,
      formToggle: false,
      t_name: "",
      oldIndex: "",
      newIndex: "",
      formToggleState: false,
      formToggleMessage: "Add a task",
    };
  },

  computed: {

    addClose() {
      return this.formToggle ? "Add " : "Close";
    },
  },

  methods: {
    onEnd: function (evt) {
      // console.log(evt);
      this.oldIndex = evt.oldIndex;
      this.newIndex = evt.newIndex;

      let item = this.list[this.oldIndex];

      this.list.splice(this.oldIndex, 1);

      this.list.splice(this.newIndex, 0, item); 

      this.list.forEach((element, i) => {
        this.listSend.push({
          t_name: element.t_name,
          priority: i,
          id: element.id,
        });
      });

      instance.put("/tasks", this.listSend).then(
        (res) => {
          this.list = res.data.data;
          this.listSend = [];
        },
        (err) => {
          console.log(err);
        }
      );
    },

    checkMove: function (e) {
      window.console.log("Future index " + e.draggedContext.futureIndex);
    },

    toggleAddTask() {
      if (!this.formToggle) {
        this.formToggle = !this.formToggle;
        this.formToggleMessage = "Close";
        this.formToggleState = false;
      } else {
        this.formToggle = !this.formToggle;
        this.formToggleMessage = "Add a task";
      }
    },

    getList() {
      instance.get("/tasks").then(
        (res) => {
          this.list = res.data.data;
        },
        (err) => {
          console.log(err);
        }
      );
    },

    handlesAddTask() {
      this.formToggle = false;
      this.formToggleMessage = 'Add a task';

      //Proceed only if t_name (task name) is NOT empty

      if (this.t_name) {
        let task = {
          t_name: this.t_name,
          priority: this.list.length,
        };

        console.log(task, "Task out");

        instance.post("/tasks", task).then(
          (res) => {
            this.getList();
            console.log(res);
          },
          (err) => {
            console.log(err);
          }
        );
      }
    },

    handlesDeleteTask(element) {
      console.log(element, "Task deleted");

      console.log(element.id, "Element ID");

      instance.delete("/tasks/" + element.id).then(
        (res) => {
          console.log(res.data.message);
          this.getList();
        },
        (err) => {
          console.log(err);
        }
      );
    },
  },
};
</script>

<style scoped>
.btn-add-close {
  margin-top: 4px;
  margin-bottom: 4px;
}

.list-group-item {
  padding: 2px 0;
  border: 1px solid rgb(68, 68, 68);
  width: 20%;
  margin: 5px 0;
}

.ghost {
  opacity: 0.5;
  background: #c8ebfb;
}

.btn-delete {
  margin-left: 60%;
  border: 1px solid rgb(114, 37, 37);
  font-family: Arial, Helvetica, sans-serif;
}
</style>


