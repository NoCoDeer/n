(function(){
  const settings = window.nokriGmapSettings || {};
  let apiPromise;

  function loadApi(){
    if(apiPromise) return apiPromise;
    if(!settings.key){
      apiPromise = Promise.reject(new Error('Google Maps API key missing'));
      return apiPromise;
    }
    apiPromise = new Promise((resolve, reject)=>{
      const cbName = '__nokriInitMap';
      window[cbName] = async () => {
        try {
          await Promise.all([
            google.maps.importLibrary('maps'),
            google.maps.importLibrary('marker'),
            google.maps.importLibrary('places')
          ]);
          if (settings.mapId && google.maps.Map) {
            const { Map } = google.maps;
            google.maps.Map = class extends Map {
              constructor(el, opts = {}) {
                opts = Object.assign({}, opts);
                if (!opts.mapId) { opts.mapId = settings.mapId; }
                super(el, opts);
              }
            };
          }
          if (google.maps.marker && google.maps.Marker) {
            const {AdvancedMarkerElement} = google.maps.marker;
            google.maps.Marker = function(opts = {}){
              const {draggable, animation, ...rest} = opts;
              if(draggable){ rest.gmpDraggable = draggable; }
              return new AdvancedMarkerElement(rest);
            };
          }
          if (typeof settings.callback === 'string' && typeof window[settings.callback] === 'function') {
            window[settings.callback]();
          }
          resolve(window.google);
        } catch (e) {
          reject(e);
        }
      };
      const script = document.createElement('script');
      let src = `https://maps.googleapis.com/maps/api/js?key=${settings.key}&callback=${cbName}&loading=async`;
      if (settings.mapId) { src += `&map_ids=${settings.mapId}`; }
      script.src = src;
      script.async = true;
      script.onerror = () => reject(new Error('Google Maps script failed to load'));
      document.head.appendChild(script);
    });
    window.nokriMapPromise = apiPromise;
    return apiPromise;
  }

  window.nokriLoadGmap = loadApi;

  function observeAndLoad(){
    const selectors = settings.selectors || '#dvMap,#googleMap,#itemMap,#contact-map';
    const target = document.querySelector(selectors);
    if(!target) return;
    const observer = new IntersectionObserver((entries, obs)=>{
      entries.forEach(entry=>{
        if(entry.isIntersecting){
          loadApi().catch(err=>console.error(err));
          obs.disconnect();
        }
      });
    });
    observer.observe(target);
  }

  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', observeAndLoad);
  } else {
    observeAndLoad();
  }
})();
