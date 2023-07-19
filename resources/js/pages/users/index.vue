<!-- <template>
  <card :title="$t('users')">
    <div class="mb-1 row">
      <div class="d-flex">
        <router-link :to="{ name: 'users.create' }">
          <v-button type="success">
            <fa :icon="icons.create" fixed-width />
          </v-button>
        </router-link>
      </div>
    </div>
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">
            #
          </th>
          <th scope="col">
            {{ $t('name') }}
          </th>
          <th scope="col">
            {{ $t('email') }}
          </th>
          <th scope="col">
            {{ $t('created_at') }}
          </th>
          <th scope="col">
            {{ $t('updated_at') }}
          </th>
          <th class="text-center">
            {{ $t('actions') }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <th scope="row">
            {{ user.id }}
          </th>
          <td>
            {{ user.name }}
          </td>
          <td>
            {{ user.email }}
          </td>
          <td>
            {{ user.created_at }}
          </td>
          <td>
            {{ user.updated_at }}
          </td>
          <td class="d-flex justify-content-center">
            <div>
              <router-link :to="{ name: 'users.edit', params: { id: user.id }}">
                <button class="btn btn-success">
                  <fa :icon="icons.edit" fixed-width />
                </button>
              </router-link>
            </div>
            <div>
              <button class="btn btn-danger ms-3" @click="del(user.id)">
                <fa :icon="icons.delete" fixed-width />
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </card>
</template> -->

<template>
  <div>
    <user-table :users=users>
    </user-table>
    <v-card v-show="dialog">
      <form @submit.prevent="create" @keydown="form.onKeydown($event)">
        <v-card-title>
          <span class="headline"></span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-col>
              <v-col cols="12" sm="12" md="12">
                <v-text-field v-model="form.name" label="Имя" type="text" name="name"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="12">
                <v-text-field v-model="form.email" label="Email" type="email" name="email"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="12">
                <v-text-field v-model="form.password" label="Пароль" type="password" name="password"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="12">
                <v-text-field v-model="form.password_confirmation" label="Подтвердите пароль" type="password" name="password_confirmation"></v-text-field>
              </v-col>
            </v-col>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
          <v-btn v-if="editedIndex" color="blue darken-1" text @click="update(idItem)">Edit</v-btn>
          <v-btn v-else color="blue darken-1" text @click="create">Save</v-btn>
        </v-card-actions>
      </form>
    </v-card>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
import Form from 'vform'
import UserTable from '~/components/UserTable'

export default {
  components: {
    UserTable
  },
  data: () => ({
    form: new Form({
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    }),
    // users: [],
    dialog: false,
    headers: [
      { text: '#', value: 'id' },
      { text: 'Имя', value: 'name' },
      { text: 'Email', value: 'email' },
      { text: 'Дата создания', value: 'created_at' },
      { text: 'Дата редактирования', value: 'updated_at' },
      { text: 'Действия', value: 'actions', sortable: false }
    ],
    editedIndex: false,
    idItem: 0,
    icons: {
      create: 'plus',
      edit: 'pen',
      delete: 'trash'
    }
  }),

  metaInfo () {
    return { title: this.$t('settings') }
  },

  computed: mapGetters({
    users: 'users/users'
  }),

  watch: {
    dialog (val) {
      val || this.close()
    }
  },

  created () {
    this.index()
  },

  methods: {
    index () {
      this.$store.dispatch('users/indexUsers')
    },

    async del (item) {
      const { data } = await axios.delete(`/api/users/${item.id}`)
      if (typeof data.error === 'undefined') {
        this.$store.dispatch('users/deleteUser', { user: item.id })
      }
    },

    editItem (item) {
      this.form.name = item.name
      this.form.email = item.email
      this.form.password = item.password
      this.form.password_confirmation = item.password_confirmation
      this.idItem = this.users[this.users.indexOf(item)].id
      this.editedIndex = true

      // this.editedIndex = this.users.indexOf(item)
      // this.editedItem = Object.assign({}, item)

      this.dialog = true
    },

    async update (id) {
      const { data } = await this.form.patch(`/api/users/${id}`)
      await this.$store.dispatch('users/updateUser', { user: data })
      this.close()
    },

    async create () {
      const { data } = await this.form.post('/api/users')
      await this.$store.dispatch('users/createUser', { user: data })
      this.close()
    },

    // deleteItem (item) {
    //   const index = this.desserts.indexOf(item)

    //   confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1)
    // },

    // async create (form) {
    //   const { data } = await form.post('/api/users')
    //   await this.$store.dispatch('users/createUser', { user: data })
    //   this.$router.push({ name: 'users.index' })
    // },

    close () {
      this.dialog = false

      this.form.name = ''
      this.form.email = ''
      this.form.password = ''
      this.form.password_confirmation = ''
      // this.$nextTick(() => {
      //   this.editedItem = Object.assign({}, this.defaultItem)
      //   this.editedIndex = -1
      // })
    }

    // save () {
    //   if (this.editedIndex > -1) {
    //     Object.assign(this.desserts[this.editedIndex], this.editedItem)
    //   } else {
    //     this.desserts.push(this.editedItem)
    //   }
    //   this.close()
    // }
  }
}

// import { mapGetters } from 'vuex'
// import axios from 'axios'

// export default {
//   middleware: 'auth',

//   metaInfo () {
//     return { title: this.$t('settings') }
//   },

//   data () {
//     return {
//       icons: {
//         create: 'plus',
//         edit: 'pen',
//         delete: 'trash'
//       }
//     }
//   },

//   computed: mapGetters({
//     users: 'users/users'
//   }),

//   created () {
//     this.index()
//   },

//   methods: {
//     async index () {
//       const { data } = await axios.get('/api/users')
//       this.$store.dispatch('users/indexUsers', { users: data })
//     },
//     async del (id) {
//       const { data } = await axios.delete(`/api/users/${id}`)
//       if (typeof data.error === 'undefined') {
//         this.$store.dispatch('users/deleteUser', { users: data })
//       }
//     }
//   }
// }
</script>

<style>
  /* .table thead th {
    height: 41px;
  }
  .table td, .table th {
    text-align: center;
    vertical-align: middle;
  } */
</style>
