/**
 * DOM-based Routing
 *
 * Based on {@link http://goo.gl/EUTi53|Markup-based Unobtrusive Comprehensive DOM-ready Execution} by Paul Irish
 *
 * The routing fires all common scripts, followed by the page specific scripts.
 * Add additional events for more control over timing e.g. a finalize event
 */
class Router {
  /**
   * Create a new Router
   * @param {Object} routes
   */
  constructor(routes) {
    this.routes = routes;
  }

  fire(route, el) {
    const event = 'init';
    const fire =
      route !== '' &&
      this.routes[route] &&
      typeof this.routes[route][event] === 'function';
    if (fire) {
      this.routes[route][event](el);
    }
  }

  /**
   * Automatically load and fire Router events
   *
   * Events are fired in the following order:
   *  * common init
   *  * page-specific init
   *  * page-specific finalize
   *  * common finalize
   */
  loadEvents() {
    const controls = Array.prototype.slice.call(
      document.querySelectorAll('[data-control]')
    );

    controls.forEach(control =>
      this.fire(control.getAttribute('data-control'), control)
    );
  }
}

export default Router;
