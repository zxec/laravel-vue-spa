<template>
  <form-user :title="$t('create')" @change="create" />
</template>

<script>
import FormUser from '~/components/FormUser'

export default {
  components: {
    FormUser
  },

  middleware: 'auth',

  methods: {
    async create (form) {
      const { data } = await form.post('/api/users')
      await this.$store.dispatch('users/createUser', { user: data })
      this.$router.push({ name: 'users.index' })
    }
  }
}
</script>
