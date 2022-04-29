const res = require("express/lib/response");
const ToDo = require('../toDoModel.js').ToDo;

describe("Todo", function () {
    it("should create a new todo", function () {
        // Given
        const newTodo = new ToDo({text: "text1", done: 0});
        let insertedTodo;

        // When
        newTodo.save(newTodo)
            .then(res => res.json())
            .then(data => insertedTodo = data)
            .catch((err) => res.status(400).send(err));

        // Then
        console.log(insertedTodo);

        expect(insertedTodo.text).toBe(newTodo.text);
        expect(insertedTodo.done).toBe(expected.done);
    });
});
