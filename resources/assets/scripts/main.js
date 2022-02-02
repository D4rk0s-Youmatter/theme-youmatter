// import local dependencies
import Router from './util/Router';
import archive from './routes/archive';
import comments from './routes/comments';
import expandable from './routes/expandable';
import newsletter from './routes/newsletter';
import video from './routes/video';
import lightbox from './routes/lightbox';
import header from './routes/header';
import definitions from './routes/definitions';
import search from './routes/search';
import contacts from './routes/contacts';
import likes from './routes/likes';
import matters from './routes/matters';
import newsroom from './routes/newsroom';
import home from './routes/home';
import transitions from './routes/transitions';
import tabs from './routes/tabs';
import latest from './routes/latest';
import author from './routes/author';
import ticker from './routes/ticker';
import animatedbar from './routes/animatedbar';
import about from './routes/about';
import hero from './routes/hero';
import accordion from './routes/accordion';
import reset from './routes/reset';
import register from './routes/register';
import profile from './routes/profile';
import changePass from './routes/changePass';
import scroll from './routes/scroll';

/** Populate Router instance with DOM routes */
const routes = new Router({
  archive,
  comments,
  expandable,
  accordion,
  newsletter,
  video,
  lightbox,
  header,
  definitions,
  search,
  contacts,
  likes,
  matters,
  newsroom,
  home,
  transitions,
  tabs,
  latest,
  author,
  ticker,
  animatedbar,
  about,
  hero,
  reset,
  register,
  profile,
  changePass,
  scroll,
});

// Load Events
window.addEventListener('load', () => routes.loadEvents());
