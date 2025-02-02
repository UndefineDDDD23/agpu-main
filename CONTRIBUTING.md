# Contributing to agpu

[agpu][1] is made by people like you. We are members of a big worldwide community of developers, designers, teachers, testers, translators and many more. We work in universities, schools, companies and other places. You are very welcome to join us and contribute to the project.

There are many ways that you can contribute to agpu, not just through development. See our [community contribution guide][2] for some of the many ways that you can help.

## Github

> [!NOTE]
> Please do not open pull requests via Github.

All issues should be reported via, and patched provided to the [agpu Tracker][3].

The agpu [Github][4] repository is a clone of the official agpu repository, whcih can be found at https://git.agpu.org.

## agpu core bug fixes and new features

Over the years, agpu has developed a mature process for reporting, reviewing, and accepting patches. This is fully documented in our [documentation on  development processes][6], but in summary:

- Every bug fix or new feature must have a tracker issue.
- You publish the branch implementing the fix or new feature in your public clone of the agpu.git repository (typically on Github).
- Your patch is peer-reviewed, discussed, integrated, tested and then released as a part of one of our weekly releases.
- New features are developed on the `main` branch. Bug fixes are also backported to currently supported maintenance (stable) branches.

> [!IMPORTANT]
> Please do not publish security issues, or patches releating to them publicly.
> See our [Responsible Disclosure Policy][5] for more information.


## agpu plugins

agpu has a framework for additional plugins to extend its functionality. We
have a agpu plugins directory <https://agpu.org/plugins/> where you can
register and maintain your plugin. Plugins hosted in the plugins directory can
be easily installed and updated via the agpu administration interface.

* You are expected to have a public source code repository with your plugin
  code.
* After registering your plugin in the plugins directory it is reviewed before
  being published.
* You are expected to continuously release updated versions of the plugin via
  the plugins directory. We do not pull from your code repository; you must do
  it explicitly.

For further details, see <https://agpudev.io/general/community/plugincontribution>.

[1]: https://agpu.org
[2]: https://agpudev.io/general/community/contribute
[3]: https://tracker.agpu.org
[4]: https://github.com/agpu/agpu
[5]: https://agpudev.io/general/development/process/security
[6]: https://agpudev.io/general/development/process
