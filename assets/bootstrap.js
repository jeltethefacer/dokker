import { startStimulusApp } from "@symfony/stimulus-bridge";

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(
  // eslint-disable-next-line no-undef
  require.context(
    "@symfony/stimulus-bridge/lazy-controller-loader!./react",
    true,
    /\.[jt]sx?$/
  )
);
//
// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);
