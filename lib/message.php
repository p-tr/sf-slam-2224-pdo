<?php

enum Type {
    case Error;
    case Success;
    case Warning;
    case Info;
    case Debug;
}

class Message {
    public function __construct(private Type $type, private string $text) {}

    public function getText() : string {
        return $this->text;
    }

    public function getType() : Type {
        return $this->type;
    }

    public function isError() : bool {
        return $this->type === Type::Error;
    }

    public function isWarning() : bool {
        return $this->type == Type::Warning;
    }

    public function isSuccess() : bool {
        return $this->type === Type::Success;
    }
}
