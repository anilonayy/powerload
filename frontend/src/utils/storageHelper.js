export const setStorage = (config) => {
  const storageData = {
    data: config.data,
    expires: new Date(config.expires)
  };

  localStorage.setItem(config.name, JSON.stringify(storageData));
};

export const getStorage = (name) => JSON.parse(localStorage.getItem(name) ?? '');

export const removeStorage = (name) => localStorage.removeItem(name);

export const removeExpiredStorages = () => {
  const storages = Object.keys(localStorage);

  storages.forEach((storage) => {
    const storageData = getStorage(storage);

    if (storageData.expires.getTime() < new Date().getTime()) {
      removeStorage(storage);
    }
  });
};
