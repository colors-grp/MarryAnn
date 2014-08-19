package com.colors.supersaym.dataprovider;

import com.colors.supersaym.controller.communication.Task;


public interface DataRequestor {
	void onStart(Task task);
	void onFinish(Task task);
}
