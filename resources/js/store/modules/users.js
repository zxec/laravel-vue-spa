import * as types from '../mutation-types'

// state
export const state = {
  users: null
}

// getters
export const getters = {
  users: state => state.users
}

// mutations
export const mutations = {
  [types.INDEX_USERS] (state, { users }) {
    state.users = users
  },
  [types.CREATE_USER] (state, { user }) {
    state.users.push(user)
  },
  [types.EDIT_USER] (state, { user }) {
    const index = state.users.findIndex(item => item.id === user.id)
    state.users[index] = user
  },
  [types.DELETE_USER] (state, { id }) {
    const index = state.users.findIndex(item => item.id === id)
    state.users.splice(index, 1)
  }
}

// actions
export const actions = {
  indexUsers ({ commit }, payload) {
    commit(types.INDEX_USERS, payload)
  },
  createUser ({ commit }, payload) {
    commit(types.CREATE_USER, payload)
  },
  updateUser ({ commit }, payload) {
    commit(types.EDIT_USER, payload)
  },
  deleteUser ({ commit }, payload) {
    commit(types.DELETE_USER, payload)
  }
}
