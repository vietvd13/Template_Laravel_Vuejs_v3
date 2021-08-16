import Cookies from 'js-cookie';

export function getLanguage() {
  const chooseLanguage = Cookies.get('language');

  if (chooseLanguage) {
    return chooseLanguage;
  }

  return process.env.MIX_LARAVEL_LANG || 'en';
}
