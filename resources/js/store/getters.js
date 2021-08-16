const getters = {
  language: state => state.app.language,
  name: state => state.user.profile.name,
  email: state => state.user.profile.email,
  expToken: state => state.user.profile.expToken,
};

export default getters;
