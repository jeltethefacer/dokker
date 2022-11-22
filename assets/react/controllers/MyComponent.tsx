import React from "react";

export default function MyComponent(props: { fullName: string }) {
  const [state, setState] = React.useState("lawl");
  const test = (): void => {
    setState("test");
  };

  console.log("test");
  return (
    <div>
      Hello {props.fullName} {state}
      <button onClick={test}>test</button>
    </div>
  );
}
