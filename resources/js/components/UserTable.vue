<template>
  <v-data-table
    :headers="headers"
    :items="users"
    locale="ru-RU"
    sort-by="calories"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>
          {{ $t('users') }}
        </v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        />
        <v-spacer />
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              v-bind="attrs"
              v-on="on"
            >
              {{ $t('create') }}
            </v-btn>
          </template>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="del(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="index">Reset</v-btn>
    </template>
  </v-data-table>
</template>

<script>
// import { mapGetters } from 'vuex'
// import axios from 'axios'

export default {
  data: () => ({
    // users: [],
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
  props: ['users'],

  metaInfo () {
    return { title: this.$t('settings') }
  },

  // computed: mapGetters({
  //   users: 'users/users'
  // }),

  // created () {
  //   this.index()
  // },

  // methods: {
  //   index () {
  //     this.$store.dispatch('users/indexUsers')
  //   },

  //   async del (item) {
  //     const { data } = await axios.delete(`/api/users/${item.id}`)
  //     if (typeof data.error === 'undefined') {
  //       this.$store.dispatch('users/deleteUser', { user: item.id })
  //     }
  //   }
  // }
}
</script>
