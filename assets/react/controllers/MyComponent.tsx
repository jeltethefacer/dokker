import React, { Fragment } from "react";

export default function MyComponent(props: { fullName: string }) {
  const [state, setState] = React.useState("lawl");
  const test = (): void => {
    setState("test");
  };

  return (
    <>
      <h1 className="text-3xl font-bold underline">
        Hello world!
      </h1>
      {props.fullName} {state}
      <button onClick={test} type="button">
        test
      </button>
    </>
  );
}
