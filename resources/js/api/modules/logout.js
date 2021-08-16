import * as RequestApi from '../request';

export function getLogout(url) {
  return RequestApi.getOne(url);
}
