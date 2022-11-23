import React, { Fragment } from "react";

export default function MyComponent(props: { fullName: string }) {
  const [state, setState] = React.useState("lawl");
  const test = (): void => {
    setState("test");
  };

  console.log("test");
  return (
    <>
      {props.fullName} {state}
      <button onClick={test} type="button">
        test
      </button>
    </>
  );
}
