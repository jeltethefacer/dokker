import React, { useState } from "react";

export default function LoginForm(props: { fullName: string }) {
  const [state, setState] = useState("lawl");
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
