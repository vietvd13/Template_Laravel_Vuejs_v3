import Cookies from 'js-cookie';

export function getProfile() {
  let PROFILE = Cookies.get('profile');

  if (PROFILE) {
    return JSON.parse(PROFILE);
  }

  PROFILE = {
    id: '',
    username: '',
    email: '',
    phone: '',
    name: '',
    fax: '',
    address: '',
    gender: '',
    email_verified_at: '',
    status: '',
  };

  return PROFILE;
}
