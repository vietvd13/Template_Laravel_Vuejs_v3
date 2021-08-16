import * as RequestApi from '../request';

export function postLogin(url, data) {
  return RequestApi.postOne(url, data);
}
